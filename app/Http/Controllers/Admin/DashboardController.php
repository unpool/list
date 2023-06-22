<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\NodeRepositoryImp;
use App\Repositories\TeacherRepositoryImp;
use App\Repositories\UserRepositoryImp;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	/** @var UserRepositoryImp */
	private $userRepo;
	/** @var TeacherRepositoryImp */
	private $teacherRepo;
	/** @var NodeRepositoryImp */
	private $nodeRepo;

	public function __construct(UserRepositoryImp $userRepo, TeacherRepositoryImp $teacherRepo, NodeRepositoryImp $nodeRepo)
	{
		$this->userRepo = $userRepo;
		$this->nodeRepo = $nodeRepo;
		$this->teacherRepo = $teacherRepo;
	}
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\View\View
	 */
	public function __invoke(Request $request): \Illuminate\View\View
	{
        $massageSendNotification = false;

        if ($request['send_notification'] == 1){
	        $massageSendNotification = true;
        }

		return view('admin.dashboard', [
			'users_count' => $this->userRepo->count(),
			'teachers_count' => $this->teacherRepo->count(),
			'products_count' => $this->nodeRepo->getCountOfProduct(),
			'teacher_group_count' => $this->teacherRepo->getCountOfGroups(),
			'teacher_group_count' => $this->teacherRepo->getCountOfGroups(),
			'teacher_group_count' => $this->teacherRepo->getCountOfGroups(),
            'massageSendNotification' => $massageSendNotification
		]);
	}
}
