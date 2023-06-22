<?php

namespace App\Repositories;

use App\Models\Invite;
use phpDocumentor\Reflection\Types\Boolean;


class InviteRepository extends BaseRepository implements InviteRepositoryImp
{
    protected $user;

    /**
     * InviteRepository constructor.
     * @param Invite $model
     * @param UserRepository $user
     */
    public function __construct(Invite $model, UserRepository $user)
    {
        parent::__construct($model);
        $this->user = $user;
    }

    /**
     * @param string $invite_code
     * @param int $user_id
     * @return bool
     */
    public function validationCode(string $invite_code, int $user_id): bool
    {
        $status = true;
        $inviter = $this->user->findOneBy(['invite_code' => $invite_code]);
        if($inviter){
        $inviter->invitedBy()->attach($user_id);
        return $status;
        }
        return false;
    }
}
