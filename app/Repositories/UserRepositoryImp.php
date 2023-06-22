<?php

namespace App\Repositories;


use App\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryImp extends BaseRepositoryImp
{
    //
    public function signUp();

    /**
     * also add in teachers
     */
    public function withdrawRequest();


    /***these methods return UserRepositoryImp and use Count or get for (filter or graph ) ***/


    /**
     * @param bool $WithInvitedLink
     * @param array $otherFilter
     * @return UserRepository
     */
    public function getUserSingUpWithInvitedLinkOrNot(bool $WithInvitedLink, array $otherFilter);

    /**
     * @param bool $WithInvitedLink
     * @param array $otherFilter
     * @return UserRepository
     */
    public function getUserSingUpWithInvitedLinkOrNotAndBuy(bool $WithInvitedLink, array $otherFilter);




    /*|--------------------------------------------------
     *| FILTER QUERY
     *|--------------------------------------------------
     */


    /**todo:maybe need move to transaction repo
     * @param String $buy_type is enum (dvd ,web ,mobile)
     * @param array $otherFilter
     * @return  UserRepository
     */
    public function getUserOneTimeBuy(String $buy_type, array $otherFilter);


    /**
     * @api active user is user that user complete profile
     * @return UserRepository
     */
    public function getUsersThatInviteOtherActiveUserThatBuyPackage();


    /**
     * @api active user is user that user complete profile
     * @return Collection
     */
    public function getUsersThatInvitedOtherActiveUser(): Collection;


    /**
     * @api active user is user that user complete profile
     * @return int
     */
    public function countOfUsersThatInvitedOtherActiveUser(): int;

    /**
     * @return Collection
     */
    public function getUsersThatInviteOthers(): Collection;

    /**
     * @return int
     */
    public function getCountOfUsersThatInviteOthers(): int;

    /**
     * @param \Datetime $from
     * @param \Datetime $to
     * @return Collection
     */
    public function getUsersWhereBirthDayIsInRange(\Datetime $from, \Datetime $to): Collection;

    /**
     * @param \Datetime $from
     * @param \Datetime $to
     * @return Collection
     */
    public function getUserWhereSingUpIsInRange(\Datetime $from, \Datetime $to): Collection;

    /**
     * @api active user is user that user complete profile
     * @return Collection
     */
    public function getActives(): Collection;

    /**
     * @return int
     */
    public function countActives(): int;


    /**
     * @param int $count
     * @param \DateTime $start
     * @param \DateTime $end
     * @return Collection
     */
    public function getUsersInvitedAnotherFilterByCountAndDate(int $count, \DateTime $start, \DateTime $end): Collection;

    public function getInviteCode();

    /**
     * @param string $mobile
     * @return bool
     */
    public function isNew(string $mobile): bool;

    /**
     * \App\User $user
     * @return \App\User|null
     */
    public function userInviteBy(\App\User $user);

    /**
     * @param \App\User $user
     * @param \App\User $inviteBy
     * @return void
     */
    public function setInviteByForUser(\App\User $user, \App\User $inviteBy);


    /**
     * @return Array
     */
    public function getUsersByScore(): array;

    /**
     * @param int $user_id
     * @return mixed
     */
    public function getInvited(int $user_id);

    /**
     * @param User $user
     * @return bool
     */
    public function moveShareToCart(User $user): bool;


    /**
     * @param User $user
     * @return bool
     */
    public function moveShareToWallet(User $user): bool;

    /**
     * @param User $user
     * @param [type] $value
     * @return boolean
     */
    public function updateWallet(User $user, $value): bool;

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function registerBetweenDate(\DateTime $start, \DateTime $end);

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function haveOrder();

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function doesNotHaveOrder();

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function incompleteProfile();

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function haveOrderBetweenDate(\DateTime $start, \DateTime $end);

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function haveIncome();

    public function findWithInviter($user_id):User;
}
