<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TeacherRepositoryImp;

class TeacherGroupController extends Controller
{
    /**
     * @var TeacherRepositoryImp $teacherRepo
     */
    private $teacherRepo;

    public function __construct(TeacherRepositoryImp $teacherRepo)
    {
        $this->teacherRepo = $teacherRepo;
    }

    public function index(): \Illuminate\View\View
    {
        return view('admin.teacher.group.index', [
            'items' => $this->teacherRepo->getPaginatedHeadGroups()
        ]);
    }

    /**
     * @return  \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $t = $this->teacherRepo->getTeachersCanBeMemberOfGroup();
        if (!$t->count()) {
            session()->flash('alert', [
                'type' => 'warning',
                'message' => 'هیچ مربی در سیستم ثبت نشده است.'
            ]);
            return redirect()->to(route('admin.teachers.group.index'));
        }
        return view('admin.teacher.group.create', [
            'teachersCanBeMemberOfGroup' => $t
        ]);
    }

    public function store(\App\Http\Requests\Admin\TeacherGroupRequest $request)
    {
        /** @var \App\Models\Teacher $teacher */

        $teacher = $this->teacherRepo->find((int)$request->get('groupHead'));
        /** @var \App\Models\TeacherGroup $headOfGroup */
        $headOfGroup = $teacher->group()->create([
            'group' => null
        ]);
        /** @var array $group */
        $group = [];
        foreach ($request->get('members') as $member) {
            if ($member != $request->get('groupHead'))
                $group[] = [
                    'teacher_id' => (int) $member,
                    'group' => $headOfGroup->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
        }

        // add members
        $headOfGroup->members()->createMany($group);

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.teachers.group.index'));
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {

        $t = $this->teacherRepo->getTeachersCanBeMemberOfGroup();
        if (!$t->count()) {
            session()->flash('alert', [
                'type' => 'warning',
                'message' => 'هیچ مربی در سیستم ثبت نشده است.'
            ]);
            return redirect()->to(route('admin.teachers.group.index'));
        }

        /** @var \App\Models\Teacher $headOfGroup */


        $headOfGroup = $this->teacherRepo->getHeadOfGroup((int)$id);
        return view('admin.teacher.group.edit', [
            'groupId' => $id,
            'headOfGroup' => $headOfGroup,
            'membersOfGroup' => $this->teacherRepo->getMembersOfGroup($headOfGroup),
            'teachersCanBeMemberOfGroup' => $this->teacherRepo->getTeachersCanBeMemberOfGroup()
        ]);
    }

    public function update($id, \App\Http\Requests\Admin\TeacherGroupRequest $request)
    {
        /** @var \App\Models\TeacherGroup $group */

        $group = $this->teacherRepo->findGroup((int)$id);

        // update head of group
        $this->teacherRepo->updateHeadOfGroup($group, (int)$request->get('groupHead'));

        // update members
        $this->teacherRepo->updateMembersOfGroup($group, $request->get('members'));

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.teachers.group.index'));
    }
}
