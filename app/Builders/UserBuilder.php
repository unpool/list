<?php

namespace App\Builders;


use App\Models\Invite;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserBuilder extends BaseBuilder
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return UserBuilder
     */
    public function whereBirthDayIsInRange(\DateTime $from, \DateTime $to): UserBuilder
    {
        $this->model = $this->model->filterByBirthday($from, $to);
        return $this;
    }

    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return UserBuilder
     */
    public function whereSingUpIsInRange(Carbon $from, Carbon $to): UserBuilder
    {
        $this->model = $this->model->filterByCreatedAt($from, $to);
        return $this;
    }

    /**
     * @return UserBuilder
     */
    public function invitedOthers(): UserBuilder
    {
        $this->model = $this->model->whereHas('invitedFrom');
        return $this;
    }

    public function invitedInActiveUsers(): UserBuilder
    {
        $this->model = $this->model
            ->with('invitedFrom')
            ->whereHas('invitedFrom', function (Builder $query) {
                $query
                    ->where('first_name', '')
                    ->orWhere('last_name', '')
                    ->orWhere('email', '');
            });
        return $this;
    }

    public function usersInvitedAnotherFilterByCountAndDate(int $count, \DateTime $start, \DateTime $end): UserBuilder
    {
        /** @var array $res */
        $res = Invite::where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->select('user_id', \DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->havingRaw('count(*) > ?', [$count])->get()->pluck('user_id')->toArray();
        $this->model = $this->model->whereIn('id', $res);
        return $this;
    }

    public function usersWhichHaveNotAnyInvite(): UserBuilder
    {
        $this->model = $this->model
            ->doesntHave('invitedBy');
        return $this;
    }

    /**
     * @return UserBuilder
     */
    public function actives(): UserBuilder
    {
        $this->model = $this->model
            ->where('first_name', '!=', '')
            ->where('last_name', '!=', '')
            ->where('email', '!=', '');
        return $this;
    }
}
