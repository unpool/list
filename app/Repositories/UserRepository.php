<?php

namespace App\Repositories;


use App\Builders\UserBuilder;
use App\Models\UserIMIE;
use App\User;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryImp
{
    /**
     * @var UserBuilder
     */
    private $user_builder;

    /**
     * UserRepository constructor.
     * @param User $model
     * @param UserBuilder $user_builder
     */
    public function __construct(User $model, UserBuilder $user_builder)
    {
        parent::__construct($model);
        $this->user_builder = $user_builder;
    }

    public function signUp()
    {
        // TODO: Implement signUp() method.
    }

    /**
     * also add in teachers
     */
    public function withdrawRequest()
    {
        // TODO: Implement withdrawRequest() method.
    }

    /**
     * @param bool $WithInvitedLink
     * @param array $otherFilter
     * @return UserRepository
     */
    public function getUserSingUpWithInvitedLinkOrNot(bool $WithInvitedLink, array $otherFilter)
    {
        // TODO: Implement getUserSingUpWithInvitedLinkOrNot() method.
    }

    /**
     * @param bool $WithInvitedLink
     * @param array $otherFilter
     * @return UserRepository
     */
    public function getUserSingUpWithInvitedLinkOrNotAndBuy(bool $WithInvitedLink, array $otherFilter)
    {
        // TODO: Implement getUserSingUpWithInvitedLinkOrNotAndBuy() method.
    }


    /**todo:maybe need move to transaction repo
     * @param String $buy_type is enum (dvd ,web ,mobile)
     * @param array $otherFilter
     * @return  UserRepository
     */
    public function getUserOneTimeBuy(String $buy_type, array $otherFilter)
    {
        // TODO: Implement getUserOneTimeBuy() method.
    }


    /**
     * @api active user is user that user complete profile
     * @return UserRepository
     */
    public function getUsersThatInviteOtherActiveUserThatBuyPackage()
    {
        // TODO: Implement getUsersThatInviteOtherActiveUserThatBuyPackage() method.
    }


    //////////// COMPLETE

    /**
     * @api active user is user that user complete profile
     * @return Collection
     */
    public function getUsersThatInvitedOtherActiveUser(): Collection
    {
        /** @var array $invited_inactive_users */
        $invited_inactive_users = $this->user_builder->invitedInActiveUsers()->get()->pluck('id')->toArray();

        /** @var array $users_which_have_not_any_invite */
        $users_which_have_not_any_invite = (new UserBuilder(new User()))->usersWhichHaveNotAnyInvite()->get()->pluck('id')->toArray();

        return $this->model->with('invites.user')->whereNotIn('id', array_merge($invited_inactive_users, $users_which_have_not_any_invite))->get();
    }

    /**
     * @return int
     */
    public function countOfUsersThatInvitedOtherActiveUser(): int
    {
        return $this->user_builder->invitedInActiveUsers()->count();
    }

    public function findWithInviter($user_id): User
    {
        return
            $this->model->with(['invitedFrom' => function ($query) {
                $query->limit(1);

            }])->findOrFail($user_id);
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return Collection
     */
    public function getUserWhereSingUpIsInRange(\DateTime $from, \DateTime $to): Collection
    {
        return $this->user_builder->whereSingUpIsInRange($from, $to)->get();
    }

    /**
     * @return Collection
     */
    public function getUsersThatInviteOthers(): Collection
    {
        return $this->user_builder->invitedOthers()->get();
    }

    /**
     * @return int
     */
    public function getCountOfUsersThatInviteOthers(): int
    {
        return $this->user_builder->invitedOthers()->count();
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return Collection
     */
    public function getUsersWhereBirthDayIsInRange(\DateTime $from, \DateTime $to): Collection
    {
        return $this->user_builder->whereBirthDayIsInRange($from, $to)->get();
    }

    /**
     * @api active user is user that user complete profile
     * @return Collection
     */
    public function getActives(): Collection
    {
        return $this->user_builder->actives()->get();
    }

    /**
     * @return int
     */
    public function countActives(): int
    {
        return $this->user_builder->actives()->count();
    }

    public function getUsersInvitedAnotherFilterByCountAndDate(int $count, \DateTime $start, \DateTime $end): Collection
    {
        /** @var Collection $res */
        return $this->user_builder->usersInvitedAnotherFilterByCountAndDate($count, $start, $end)->get();
    }

    public function getInviteCode()
    {
        $code = strtolower(generateRandomString(2)) . "-" . mt_rand(100, 999);
        $model = $this->findOneBy(['invite_code' => $code]);
        if (!empty($model)) {
            $code = $this->getInviteCode();
        }
        return $code;
    }

    /**
     * @inheritDoc
     */
    public function isNew(string $mobile): bool
    {
        $user = $this->findOneBy(['mobile' => $mobile]);
        return !empty($user) ? false : true;
    }

    /**
     * {@inheritDoc}
     */
    public function userInviteBy(\App\User $user)
    {
        return $user->invitedFromUser();
    }

    /**
     * {@inheritDoc}
     */
    public function setInviteByForUser(\App\User $user, \App\User $inviteBy)
    {
        $user->invitedFrom()->attach($inviteBy . id);
    }


    public function getUsersByScore(): array
    {
        return $this->model->orderBy('score', 'desc')->paginate()->toArray();
    }

    public function getInvited(int $user_id)
    {
        return $this->model->findorfail($user_id)->invites()->with('user')->orderBy('id', 'desc')->paginate();
    }


    /**
     * @param User $user
     * @return bool
     */
    public function moveShareToWallet(User $user): bool
    {
        $user->wallet = $user->wallet + $user->share;
        $user->share = 0;
        return $user->save();
    }


    /**
     * @param User $user
     * @return bool
     */
    public function moveShareToCart(User $user): bool
    {
        $user->share = 0;
        return $user->save();
    }

    /**
     * @param User $user
     * @param [type] $value
     * @return boolean
     */
    public function updateWallet(User $user, $value): bool
    {
        $user->wallet = $value;
        return $user->save();
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function registerBetweenDate(\DateTime $start, \DateTime $end)
    {
        return $this->model
            ->where('created_at', '<=', $end)
            ->where('created_at', '>=', $start)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function haveOrder()
    {
        return $this->model
            ->whereHas('orders', function (Builder $query) {
                $query
                    ->where('type', \App\Enums\OrderType::BUYNODE)
                    ->where('is_paid', 1);
            })->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function doesNotHaveOrder()
    {
        /** @var array $items */
        $items = $this->haveOrder()->pluck('id')->toArray();
        if ($items) {
            return $this->model->whereNotIn('id', $items)->get();
        } else {
            return $this->model->all();
        }
    }


    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function haveOrderBetweenDate(\DateTime $start, \DateTime $end)
    {
        return $this->model
            ->whereHas('orders', function (Builder $query) use ($start, $end) {
                $query
                    ->where('type', \App\Enums\OrderType::BUYNODE)
                    ->where('is_paid', 1)
                    ->where('created_at', '<=', $end)
                    ->where('created_at', '>=', $start);
            })->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function incompleteProfile()
    {
        /**
         * @var \Illuminate\Database\Eloquent\Collection $activeUsers
         */
        $activeUsers = $this->getActives();
        if ($activeUsers->count()) {
            /**
             * @var array $activeUsers
             */
            $activeUsers = $this->getActives()->pluck('id')->toArray();
            return $this->model->whereNotIn('id', $activeUsers)->get();
        } else {
            return $this->model->all();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function haveIncome()
    {
        return $this->model->where('share', '>', 0)->get();
    }
}
