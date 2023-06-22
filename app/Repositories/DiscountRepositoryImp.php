<?php

namespace App\Repositories;

use App\Models\Discount;

interface DiscountRepositoryImp extends BaseRepositoryImp
{
    /**
     * @param string $code
     * @return boolean
     */
    public function checkDiscountCodeIsActive(string $code): bool;

    /**
     * @param Discount $discount
     * @return int|null
     */
    public function getNumberOfTimesAllowedToUse(Discount $discount);

    /**
     * @return array
     */
    public function getRawValueFormat(): array;

    /**
     * @param array $value
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function setDateInValue(array $value, \DateTime $start, \DateTime $end): array;

    /**
     * @param array $value
     * @param integer $count
     * @return array
     */
    public function setCountInValue(array $value, int $count): array;

    /**
     * @param array $value
     * @param int[] $users_id
     * @return array
     */
    public function setAllowedUsersIdInValue(array $value, array $users_id): array;

    /**
     * @param Discount $discount
     * @return array
     */
    public function getPriodTimeFromDiscountValue(Discount $discount): array;

    /**
     * @param Discount $discount
     * @return array
     */
    public function getUsersCanUserFromDiscount(Discount $discount): array;
}
