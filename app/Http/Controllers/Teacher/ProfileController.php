<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Requests\Teacher\ProfileRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpFoundation\File\File;
use App\Repositories\TeacherRepositoryImp;
class ProfileController extends Controller
{
  /** @var TeacherRepositoryImp $teacherRepo */
  private $teacherRepo;
  public function __construct(TeacherRepositoryImp $teacherRepo) {
	$this->teacherRepo = $teacherRepo;
  }
    /**
     * Display a listing of the resource.
     *
     */
    public function index():View
    {
        return view('teacher.profile.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return View
     */
    public function edit():View
    {
        return view('teacher.profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProfileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request)
    {
        /**
         * LoginTeacher is instance from Teacher Model
         */
        try {
            login_teacher()->update([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
            ]);

            if (login_teacher()->cv) {
                login_teacher()->cv->update([
                    'cv' => $request->get('cv')
                ]);
            } else {
                login_teacher()->cv()->create([
                    'cv' => $request->get('cv')
                ]);
            }

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
        return redirect()->to(route('teacher.profile.index'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tinyMceImageUpload(Request $request)
    {
	   /** @var UploadedFile $file */
       $file = $request->all()['file'];
	   /** @var \Symfony\Component\HttpFoundation\File\File $res */
	   $res = $this->teacherRepo->uploadTinyMCEImage($file,login_teacher()->id);

	   return response()->json([
		 'location' => asset($res->getPathname())
	   ]); 
    }
}
