<?php
namespace App\Traits;

use Morilog\Jalali\CalendarUtils;
trait DatetimeAccessorTrait
{
    /**
     * @return string
     */
    public function getJalaliCreatedAtAttribute()
    {
        return CalendarUtils::convertNumbers(CalendarUtils::strftime('Y/m/d H:i:s', $this->created_at));
    }

    /**
     * @return string
     */
    public function getJalaliUpdatedAtAttribute()
    {
        return CalendarUtils::convertNumbers(CalendarUtils::strftime('Y/m/d H:i:s', $this->updated_at));
    }
}
