<?php

namespace App\Repositories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class DiscountRepository extends BaseRepository implements DiscountRepositoryImp
{
    /**
     * DiscountRepository constructor.
     * @param Discount $model
     */
    public function __construct(Discount $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array
     */
    public function getRawValueFormat(): array
    {
        return [
            'date' => [
                'start_at' => null,
                'end_at' => null
            ],
            'count' => null,
            'users_id' => []
        ];
    }

    /**
     * @param array $value
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function setDateInValue(array $value, \DateTime $start, \DateTime $end): array
    {
        $value['date']['start_at'] = $start->getTimestamp();
        $value['date']['end_at'] = $end->getTimestamp();
        return $value;
    }

    /**
     * @param array $value
     * @param integer $count
     * @return array
     */
    public function setCountInValue(array $value, int $count): array
    {
        $value['count'] = $count;
        return $value;
    }

    /**
     * @param array $value
     * @param int[] $users_id
     * @return array
     */
    public function setAllowedUsersIdInValue(array $value, array $users_id): array
    {
        $value['users_id'] = $users_id;
        return $value;
    }


    /**
     * @param Discount $discount
     * @return int|null
     */
    public function getNumberOfTimesAllowedToUse(Discount $discount)
    {
        if ($discount->type == 'count') {
            /** @var array $value */
            $value = json_decode($discount->value, true);
            return $value['count'] ?? null;
        }
        return null;
    }

    /**
     * @param Discount $discount
     * @return array
     */
    public function getPriodTimeFromDiscountValue(Discount $discount): array
    {
        /** @var array $value */
        $value = json_decode($discount->value, true);
        return $value['date'] ?? [];
    }

    /**
     * @param Discount $discount
     * @return array
     */
    public function getUsersCanUserFromDiscount(Discount $discount): array
    {
        /** @var array $value */
        $value = json_decode($discount->value, true);
        return $value['users_id'] ?? [];
    }

    /**
     * @param string $code
     * @return boolean
     */
    public function checkDiscountCodeIsActive(string $code): bool
    {
        /** @var \App\Models\Discount $discount */
        $discount = $this->model
            ->where('code', $code)
            ->first();
        if (!$discount) {
            return false;
        }

        if ($discount->type == 'time') {
            $periodTime = $this->getPriodTimeFromDiscountValue($discount);
            if (
                $periodTime['start_at'] < time() and
                $periodTime['end_at'] > time()
            ) {
                return true;
            }
        } else if ($discount->type = 'count') {
            if ((int) $this->getNumberOfTimesAllowedToUse($discount)) {
                return true;
            }
        } else {
            if (
                count($this->getUsersCanUserFromDiscount($discount))
            ) {
                return true;
            }
        }
        return false;
    }
}
