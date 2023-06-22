<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Slider;
use App\Models\Media;
use App\Repositories\MediaRepositoryImp;
use App\Repositories\NodeRepositoryImp;
use App\Repositories\SliderRepositoryImp;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class SliderController extends Controller
{
    /** * @var NodeRepositoryImp */
    private $nodeRepo;

    /** * @var MediaRepositoryImp */
    private $mediaRepo;

    /** * @var SliderRepositoryImp $sliderRepo */
    private $sliderRepo;

    public function __construct(NodeRepositoryImp $nodeRepo, MediaRepositoryImp $mediaRepo, SliderRepositoryImp $sliderRepo)
    {
        $this->nodeRepo = $nodeRepo;
        $this->mediaRepo = $mediaRepo;
        $this->sliderRepo = $sliderRepo;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.slider.index', [
            'items' => $this->sliderRepo->getPaginatedList()
        ]);
    }

    /**
     * @return View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        /** @var \Illuminate\Database\Eloquent\Collection $roots */
        $roots = $this->nodeRepo->getRoots();
        if(!$roots->count()){
            session()->flash('alert', [
                'type' => 'warning',
                'message' => 'هیچ دسته بندی ثبت نشده است.',
            ]);
            return redirect(route('admin.slider.index'));
        }
        return view('admin.slider.create', [
            'root_nodes' => $roots
        ]);
    }

    /**
     * @param Slider $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Slider $request): RedirectResponse
    {
        $file = $request->file('image');
        $originalName = $request->file('image')->getClientOriginalName();
        $imageNmae = time().$originalName;
        $path = '/upload/slider/'.$imageNmae;
        $file->storeAs('public/upload/slider/',$imageNmae);

        /** * @var \App\Models\Slider $slider */
        $slider = $this->sliderRepo->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'link' => $request->get('url'),
            'node_id' => $request->get('category'),
            'image'   => $path
        ]);

        /** @var UploadedFile $file */
        $file = $request->file('file');
        /** @var string $fileType */
        $fileType = (new \App\Models\Media())->getTypeOfFile($file);
        /** @var int $size unit is KB */
        $size = $file->getSize();

        try {
            /** @var \Symfony\Component\HttpFoundation\File\File $res */
            $res = fileUploader(
                $file,
                'upload' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR . $slider->id . DIRECTORY_SEPARATOR
            );
        } catch (\Exception $th) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'در بارگذاری فایل خطایی رخ داده است.',
            ]);
            return redirect()->to(route('admin.slider.index'));
        }

        // create in media
        /** @var Media $media */
        $media = $this->mediaRepo->create([
            'size' => $size,
            'path' => $res->getFilename(),
            'duration' => 0,
        ]);

        // assign to Slider
        $slider->medias()->attach($media->id, ['type' => $fileType]);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.slider.index'));
    }

    /**
     * @param integer $slider
     * @param [type] $file_name
     * @return void
     */
    public function download(int $slider, $file_name)
    {
        if (file_exists(public_path('upload' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR . $slider . DIRECTORY_SEPARATOR . $file_name))) {
            return response()->download(public_path('upload' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR . $slider . DIRECTORY_SEPARATOR . $file_name));
        }
        session()->flash('alert', [
            'type' => 'danger',
            'message' => 'متاسفانه خطایی در دانلود فایل رخ داده است.'
        ]);
        return redirect()->to(route('admin.slider.index'));
    }

    public function destroy($slider)
    {
        /** * @var \App\Models\Slider $slider */
        $slider = $this->sliderRepo->findOneOrFail($slider);
        try {
            removeFilesInDirectory('upload' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR . $slider->id);
            $sliderMedias = $slider->medias;
            $slider->medias()->detach();
            $this->sliderRepo->forceDelete($slider->id);
            foreach ($sliderMedias as $media) {
                $media->forceDelete();
            }
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'متاسفانه خطایی رخ داده است.',
            ]);
            return redirect()->to(route('admin.slider.index'));
        }
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.slider.index'));
    }

    public function edit($slider)
    {
        $slider =  $this->sliderRepo->findOneOrFail($slider);
        return view('admin.slider.edit', [
            'root_nodes' => $this->nodeRepo->getRoots(),
            'slider' => $slider,
            'category' => $slider->node
        ]);
    }

    public function update($slider, \App\Http\Requests\Admin\Slider $request)
    {
        if($request->hasFile('image')) {

            $file = $request->file('image');
            $originalName = $request->file('image')->getClientOriginalName();
            $imageNmae = time().$originalName;
            $path = '/upload/slider/'.$imageNmae;
            $file->storeAs('public/upload/slider/',$imageNmae);

            //unlink('storage'.$slider->image);
            $slider = $this->sliderRepo->findOneOrFail($slider);
            $slider->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'link' => $request->get('url'),
                'node_id' => $request->get('category'),
                'image'   => $path,
            ]);
        } else {
            $slider = $this->sliderRepo->findOneOrFail($slider);
            $slider->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'link' => $request->get('url'),
                'node_id' => $request->get('category'),
            ]);
        }


        if ($request->file('file')) {
            try {
                removeFilesInDirectory('upload' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR . $slider->id);
            } catch (\Exception $e) {
                session()->flash('alert', [
                    'type' => 'danger',
                    'message' => 'در بارگذاری فایل خطایی رخ داده است.',
                ]);
            }

            /** @var UploadedFile $file */
            $file = $request->file('file');

            /** @var string $fileType */
            $fileType = (new \App\Models\Media())->getTypeOfFile($file);

            /** @var int $size unit is KB */
            $size = $file->getSize();

            try {
                /** @var \Symfony\Component\HttpFoundation\File\File $res */
                $res = fileUploader(
                    $file,
                    'upload' . DIRECTORY_SEPARATOR . 'slider' . DIRECTORY_SEPARATOR . $slider->id . DIRECTORY_SEPARATOR
                );
            } catch (\Exception $th) {
                session()->flash('alert', [
                    'type' => 'danger',
                    'message' => 'در بارگذاری فایل خطایی رخ داده است.',
                ]);
                return redirect()->to(route('admin.slider.index'));
            }

            // create in media
            /** @var Media $media */
            $media = $this->mediaRepo->create([
                'size' => $size,
                'path' => $res->getFilename(),
                'duration' => 0,
            ]);

            // assign to Slider
            $slider->medias()->detach();
            $slider->medias()->attach($media->id, ['type' => $fileType]);
        }
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.slider.index'));
    }
}
