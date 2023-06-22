<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\TeacherRepositoryImp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Teacher as AdminTeacher;
use App\Models\Teacher;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use App\Repositories\PermissionRepositoryImp;
use App\Repositories\NodeRepositoryImp;
use App\Repositories\RoleRepositoryImp;

class TeacherController extends Controller
{
    /** @var NodeRepositoryImp $nodeRepo */
    private $nodeRepo;

    /** * @var TeacherRepositoryImp */
    private $teacherRepo;

    /** @var PermissionRepositoryImp */
    private $permissionRepo;

    /** @var RoleRepositoryImp */
    private $roleRepo;

    public function __construct(TeacherRepositoryImp $teacherRepo, PermissionRepositoryImp $permissionRepo, RoleRepositoryImp $roleRepo, NodeRepositoryImp $nodeRepo)
    {
        $this->teacherRepo = $teacherRepo;
        $this->permissionRepo = $permissionRepo;
        $this->roleRepo = $roleRepo;
        $this->nodeRepo = $nodeRepo;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.teacher.index', [
            'all_teacher_permission' => $this->permissionRepo->allTeacherPermissionsId(),
            'items' => $this->teacherRepo->paginate(10, 'id', 'desc', ['roles', 'permissions'])
        ]);
    }

    public function show($id): View
    {
        return view('admin.teacher.show', [
            'item' => $this->teacherRepo->findOneOrFail($id)
        ]);
    }

    public function create(): View
    {
        return view('admin.teacher.create', [
            'root_nodes' => $this->nodeRepo->getRoots()
        ]);
    }

    public function store(\App\Http\Requests\Admin\Teacher $request)
    {
        /** @var array $data */
        $data = $request->all();
        $data['password'] = \Hash::make($request->get('password'));

        /** @var \App\Models\Teacher $teacher */
        $teacher = $this->teacherRepo->create($data);

        // assing role
        $teacher->assignRole($this->roleRepo->findByName(\App\Enums\RoleType::TEACHER));

        $permissions = [];

        $teacher->nodePermissionable()->sync($request->get('category') ? array_values($request->get('category')) : []);
        if ($request->get('category')) {
            $permissions[] = $this->permissionRepo->findByName(\App\Enums\PermissionType::PRODUCT_MANAGE)->id;
        }

        if ($request->has('commentPermission')) {
            $permissions[] = $this->permissionRepo->findByName(\App\Enums\PermissionType::COMMENT_MANAGE)->id;
        }

        // update permission 
        $teacher->syncPermissions($permissions);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.teachers.index'));
    }

    public function edit($id): \Illuminate\View\View
    {
        /** @var \App\Models\Teacher $teacher */
        $teacher = $this->teacherRepo->find($id);
        /** @var array $permissions */
        $permissions = $teacher->permissions->pluck('id')->toArray();
        $teacherHaveCommentManagePermission = in_array($this->permissionRepo->findByName(\App\Enums\PermissionType::COMMENT_MANAGE)->id, $permissions);
        $teacherCategoryPermissions = $teacher->nodePermissionable->pluck('id')->toArray();
        return view('admin.teacher.edit', [
            'teacher' => $this->teacherRepo->find($id),
            'teacher_permissions_id' => $permissions,
            'root_nodes' => $this->nodeRepo->getRoots(),
            'teacherHaveCommentManagePermission' => $teacherHaveCommentManagePermission,
            'teacherCategoryPermissions' => $teacherCategoryPermissions
        ]);
    }

    /**
     * @param int $id
     * @param AdminTeacher $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, AdminTeacher $request): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\Teacher $teacher */
        $teacher = $this->teacherRepo->find((int) $id);
        $this->teacherRepo->update(array_merge(
            $request->only(['first_name', 'last_name', 'email']),
            !is_null($request->password) ? ['password' => \Hash::make($request->password)] : []
        ), (int) $id);


        $permissions = [];

        $teacher->nodePermissionable()->sync($request->get('category') ? array_values($request->get('category')) : []);
        if ($request->get('category')) {
            $permissions[] = $this->permissionRepo->findByName(\App\Enums\PermissionType::PRODUCT_MANAGE)->id;
        }

        if ($request->has('commentPermission')) {
            $permissions[] = $this->permissionRepo->findByName(\App\Enums\PermissionType::COMMENT_MANAGE)->id;
        }

        // update permission 
        $teacher->syncPermissions($permissions);
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.teachers.index'));
    }

    public function cvEdit($id)
    {
        return view('admin.teacher.cv.edit', [
            'teacher' => $this->teacherRepo->findOneOrFail($id)
        ]);
    }

    public function cvUpdate($id, Request $request)
    {
        /** @var Teacher $teacher */
        $teacher = $this->teacherRepo->findOneOrFail($id);

        if ($teacher->cv) {
            $teacher->cv->update([
                'cv' => $request->get('cv')
            ]);
        } else {
            $teacher->cv()->create([
                'cv' => $request->get('cv')
            ]);
        }
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.teachers.index'));
    }

    public function tinyMCEImageUpload($id, Request $request)
    {
        /** @var UploadedFile $file */
        $file = $request->all()['file'];

        /** @var \File $res */
        $res = $this->teacherRepo->uploadTinyMCEImage($file, $id);

        return response()->json([
            'location' => asset($res->getPathname()),
        ]);
    }
}
