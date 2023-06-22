<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

interface TeacherRepositoryImp extends BaseRepositoryImp
{
    public function uploadTinyMCEImage(UploadedFile $file, int $teacher_id);

    /**
     * @param integer $groupId
     * @return \App\Models\TeacherGroup|NULL
     */
    public function findGroup(int $groupId);

    /**
     * @return Collection
     */
    public function getHeadOfGroups(): Collection;

    /**
     * @return integer
     */
    public function getCountOfGroups(): int;

    /**
     * @return Collection
     */
    public function getTeachersCanBeMemberOfGroup(): Collection;

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedHeadGroups(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): \Illuminate\Pagination\LengthAwarePaginator;

    /**
     * @param Teacher $headGroup
     * @return Collection
     */
    public function getMembersOfGroup(\App\Models\Teacher $headGroup): Collection;

    /**
     * @param integer $groupId
     * @return \App\Models\Teacher
     */
    public function getHeadOfGroup(int $groupId): \App\Models\Teacher;

    /**
     * @param \App\Models\TeacherGroup $group
     * @param integer $newHeadId
     * @return boolean
     */
    public function updateHeadOfGroup(\App\Models\TeacherGroup $group, int $newHeadId): bool;

    /**
     * @param \App\Models\TeacherGroup $group
     * @param array $membersId
     * @return Collection
     */
    public function updateMembersOfGroup(\App\Models\TeacherGroup $group, array $membersId): Collection;

    /**
     * @return Collection
     */
    public function getGroupCanBeAssignToNode();

    /**
     * @param int $teacher_id
     * @return mixed
     */
    public function getInfoTeacher(int $teacher_id);
}
