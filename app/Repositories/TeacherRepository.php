<?php

namespace App\Repositories;


use App\Models\Teacher;
use File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Collection;
use PhpParser\Node\Expr\FuncCall;

class TeacherRepository extends BaseRepository implements TeacherRepositoryImp
{

    /**
     * AdminRepository constructor.
     * @param Teacher $model
     */
    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }

    /**
     * @param Teacher $teacher
     * @param array $permissions
     * @return \App\Classes\ClassResponse
     */
    public function changePermissions(Teacher $teacher, array $permissions)
    {
        $teacher->syncPermissions($permissions);

        return $this->response()
            ->setStatus(true);
    }

    /**
     * @param UploadedFile $file
     * @param int $teacher_id
     * @return File
     */
    public function uploadTinyMCEImage(UploadedFile $file, int $teacher_id)
    {
        $destinationPath =
            'upload' . DIRECTORY_SEPARATOR .
            'teachers' . DIRECTORY_SEPARATOR .
            'profile' . DIRECTORY_SEPARATOR .
            $teacher_id . DIRECTORY_SEPARATOR;
        /** @var \Symfony\Component\HttpFoundation\File\File $res */
        $res = $file->move($destinationPath, $file->getClientOriginalName());
        return $res;
    }


    /**
     * @param integer $groupId
     * @return \App\Models\TeacherGroup|NULL
     */
    public function findGroup(int $groupId)
    {
        return \App\Models\TeacherGroup::find($groupId);
    }

    /**
     * @return Collection
     */
    public function getHeadOfGroups(): Collection
    {
        return $this->model->whereHas('group', function (Builder $query) {
            $query->where('group', null);
        })
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * @return Collection
     */
    public function getTeachersCanBeMemberOfGroup(): Collection
    {
        return $this->model->with('permissions')->doesntHave('group')
            ->orderBy('id', 'DESC')
            ->get();
    }


    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedHeadGroups(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        if ($with) {
            return $this->model->whereHas('group', function (Builder $query) {
                $query->where('group', null);
            })
                ->orderBy($orderBy, $sortType)
                ->with($with)
                ->paginate($limit);
        }

        return $this->model->whereHas('group', function (Builder $query) {
            $query->where('group', null);
        })
            ->orderBy($orderBy, $sortType)
            ->paginate($limit);
    }

    /**
     * @param Teacher $headGroup
     * @return Collection
     */
    public function getMembersOfGroup(Teacher $headGroup): Collection
    {
        return Collection::make($headGroup->group->members()->with('teacher')->get()->pluck('teacher'));
    }

    /**
     * @param integer $groupId
     * @return \App\Models\Teacher
     */
    public function getHeadOfGroup(int $groupId): \App\Models\Teacher
    {
        return $this->model->whereHas('group', function (Builder $query) use ($groupId) {
            $query->where('id', $groupId);
        })->first();
    }

    /**
     * @param \App\Models\TeacherGroup $group
     * @param integer $newHeadId
     * @return boolean
     */
    public function updateHeadOfGroup(\App\Models\TeacherGroup $group, int $newHeadId): bool
    {
        if ($item = $this->findGroup($newHeadId)) {
            $item->delete();
        }

        return $group->update([
            'teacher_id' => $newHeadId
        ]);
    }

    /**
     * @param \App\Models\TeacherGroup $group
     * @param array $membersId
     * @return Collection
     */
    public function updateMembersOfGroup(\App\Models\TeacherGroup $group, array $membersId): Collection
    {
        $group->members()->delete();
        $items = [];
        foreach ($membersId as  $value) {
            if ($value != $group->teacher_id)
                $items[] = [
                    'teacher_id' => $value
                ];
        }

        return $group->members()->createMany($items);
    }

    /**
     * @return integer
     */
    public function getCountOfGroups(): int
    {
        return $this->model->whereHas('group', function (Builder $query) {
            $query->where('group', null);
        })->count();
    }

    /**
     * @return Collection
     */
    public function getGroupCanBeAssignToNode()
    {
        return \App\Models\TeacherGroup::where('group', null)
            ->with('teacher')->get();
    }

    public function getInfoTeacher(int $teacher_id)
    {
        return $this->model->with('cv')->where('id', $teacher_id)->first();
    }
}
