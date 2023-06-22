<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Enums\PriceType;
use App\Models\Node;
use App\Repositories\{NodeRepositoryImp, TeacherRepositoryImp, MediaRepositoryImp};
use App\Http\Requests\Admin\PackageRequest;
use App\Repositories\NodeMediaRepositoryImp;

class PackageController extends Controller
{
    /** @var NodeRepositoryImp $nodeRepo */
    private $nodeRepo;

    /** @var TeacherRepositoryImp $teacherRepo */
    private $teacherRepo;

    /** @var MediaRepositoryImp $mediaRepo */
    private $mediaRepo;

    /** @var NodeMediaRepositoryImp $nodeMediaRepo */
    private $nodeMediaRepo;

    public function __construct(NodeRepositoryImp $nodeRepo, TeacherRepositoryImp $teacherRepo, MediaRepositoryImp $mediaRepo, NodeMediaRepositoryImp $nodeMediaRepo)
    {
        $this->nodeRepo = $nodeRepo;
        $this->teacherRepo = $teacherRepo;
        $this->mediaRepo = $mediaRepo;
        $this->nodeMediaRepo = $nodeMediaRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $packages */
        $packages = $this->nodeRepo->getPaginatedPackages();

        foreach ($packages as $item) {
            /** @var \App\Models\Node $item */
            $item->fromRootToNode = $this->nodeRepo->getFromRootToParent($item)->sortBy('id')->pluck('title')->toArray();
            $this->nodeRepo->addPriceToAttributes($item);
        }

        return view('admin.package.index', [
            'items' => $packages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $groups = $this->teacherRepo->getGroupCanBeAssignToNode();
        if ($groups->isEmpty()) {
            session()->flash('alert', [
                'type' => 'warning',
                'message' => 'هیچ گروهی از مربیان ثبت نشده است.',
            ]);
            return redirect(route('admin.package.index'));
        }
        return view('admin.package.create', [
            'groups' => $groups,
            'root_nodes' => $this->nodeRepo->getRoots()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PackageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        try {
            /** @var \App\Models\Node $parent */
            $parent = $this->nodeRepo->find((int) $request->get('category'));

            /** @var \App\Models\Node $package */
            $package = $this->nodeRepo->addChildNode([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'is_product' => true,
                'ownerable_type' => \App\Models\TeacherGroup::class,
                'ownerable_id' => (int) $request->get('group'),
                'status' => ($request->get('status') === 'publish') ? 'publish' : 'disable',
                'score' => $request->get('score')
            ], $parent);

            // save price
            $this->nodeRepo->setPriceForNode($package, [
                [
                    'type' => PriceType::CASH,
                    'amount' => (float) $request->price
                ],
                [
                    'type' => PriceType::COIN,
                    'amount' => $request->price_coin
                ],
                [
                    'type' => PriceType::DVD,
                    'amount' => $request->dvd_price
                ],
                [
                    'type' => PriceType::FLASH,
                    'amount' => $request->flash_price
                ]
            ]);

            // save product
            $this->nodeRepo->updateProductsOfPackage($package, $request->get('products'));

            session()->flash('alert', [
                'type' => 'success',
                'message' => 'با موفقیت انجام شد.',
            ]);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'متاسفانه خطایی رخ داده است.',
            ]);
        }
        return redirect(route('admin.package.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var \Illuminate\Database\Eloquent\Collection $groups */
        $groups = $this->teacherRepo->getGroupCanBeAssignToNode();
        if ($groups->isEmpty()) {
            setDangerAlertSession('هیچ گروهی از مربیان ثبت نشده است.');
            return redirect(route('admin.package.index'));
        }

        /** @var \App\Models\Node $package */
        $package = $this->nodeRepo->findOneOrFail((int) $id);

        $data = [
            'package' => $this->nodeRepo->find((int) $id),
            'groups' => $groups,
            'root_nodes' => $this->nodeRepo->getRoots(),
            'package_owner' => $package->ownerable ?? null,
            'productsInPackage' => $this->nodeRepo->getProductsIdInPackage($package)
        ];

        foreach ($package->prices as $price) {
            $data['prices'][$price->type] = $price->amount;
        }

        if ($iconImage = $this->nodeRepo->getNodeIconMedia($package)) {
            $data['iconImage'] = [
                'path' => $package->productMediaPath() . $iconImage->path,
                'mediaId' => $iconImage->id
            ];
        }
        if ($backgroundImage = $this->nodeRepo->getNodeBackgroundMedia($package)) {
            $data['backgroundImage'] = [
                'path' => $package->productMediaPath() . $backgroundImage->path,
                'mediaId' => $backgroundImage->id
            ];
        }
        return view('admin.package.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\PackageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\Admin\PackageRequest $request, $id)
    {
        try {
            /** @var \App\Models\Node $package */
            $package = $this->nodeRepo->findOneOrFail($id);

            // update node
            $this->nodeRepo->update([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'ownerable_type' => \App\Models\TeacherGroup::class,
                'ownerable_id' => (int) $request->get('group'),
                'status' => ($request->get('status') === 'publish') ? 'publish' : 'disable',
                'score' => $request->get('score')
            ], $id);

            // update category
            if ($request->get('category') !== $package->parent_id) {
                $this->nodeRepo->moveNode($package, $this->nodeRepo->find((int) $request->get('category')));
            }

            // update price
            $this->nodeRepo->updateCashPriceOfNode($package, $request->get('price'));
            $this->nodeRepo->updateCoinPriceOfNode($package, $request->get('price_coin'));
            $this->nodeRepo->updateFlashPriceOfNode($package, $request->get('flash_price'));
            $this->nodeRepo->updateDVDPriceOfNode($package, $request->get('dvd_price'));

            // update product
            $this->nodeRepo->updateProductsOfPackage($package, $request->get('products'));

            // icon image
            if ($request->file('icon')) {
                $res = $this->nodeMediaRepo->setNewIconImage($package, $request->file('icon'));
                if (!$res) {
                    setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
                    return redirect()->to(route('admin.product.index'));
                }
            }

            // background image
            if ($request->file('background')) {
                $res = $this->nodeMediaRepo->setNewBackgroundImage($package, $request->file('background'));
                if (!$res) {
                    setDangerAlertSession('در بارگذاری فایل خطایی رخ داده است.');
                    return redirect()->to(route('admin.product.index'));
                }
            }
            setSuccessAlertSession();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            setDangerAlertSession();
        }
        return redirect(route('admin.package.index'));
    }

    public function destroy($package)
    {
        //TODO : Remove Files And Prices And All related things after 1month after soft delete
        $res = $this->nodeRepo->delete($package);
        if ($res) {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'با موفقیت انجام شد.'
            ]);
        } else {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'متاسفانه خطایی رخ داده است.'
            ]);
        }
        return redirect(route('admin.package.index'));
    }

    /**
     *
     * @param string $id
     * @param string $mediaId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fileDelete($id, $mediaId): \Illuminate\Http\RedirectResponse
    {
        try {
            /** @var \App\Models\Node $package */
            $package = $this->nodeRepo->findOneOrFail((int) $id);

            /** @var \App\Models\Media $media */
            $media = $package->medias->where('id', (int) $mediaId)->first();

            // remove old picture
            if ($media->pivot->type === \App\Enums\MediaType::IMAGE) {
                removeMediaFromDirectory(
                    $package->productMediaPath() . $media->path
                );
            } else {
                $res = \Storage::disk('public')->delete(
                    $package->productMediaPath() . $media->path
                );
            }
            $package->medias()->detach((int) $mediaId);
            $this->mediaRepo->forceDelete($mediaId);

            session()->flash('alert', [
                'type' => 'success',
                'message' => 'با موفقیت انجام شد.'
            ]);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'متاسفانه خطایی رخ داده است.'
            ]);
        }
        return redirect(route('admin.package.edit', ['id' => $id]));
    }
}
