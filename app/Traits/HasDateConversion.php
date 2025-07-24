<?php
// app/Traits/HasDateConversion.php
namespace App\Traits;

use InvalidArgumentException;
use Morilog\Jalali\Jalalian;

trait HasDateConversion
{
    protected function toMiladi(string $jDate): string
    {
        // حذف همه کاراکترهای غیرعددی و اسلاش
        $cleaned = preg_replace('/[^\d\/]/', '', $jDate);

        // تجزیه بخش‌های تاریخ
        $parts = array_filter(explode('/', $cleaned));

        if (count($parts) !== 3) {
            throw new InvalidArgumentException('فرمت تاریخ نامعتبر. باید به صورت سال/ماه/روز باشد');
        }

        [$year, $month, $day] = $parts;

        // اعتبارسنجی اعداد
        if (!is_numeric($year) || !is_numeric($month) || !is_numeric($day)) {
            throw new InvalidArgumentException('سال، ماه و روز باید عدد باشند');
        }

        // نرمال‌سازی به فرمت چهاررقمی سال و دورقمی ماه و روز
        $year = (int)$year;
        $month = (int)$month;
        $day = (int)$day;

        try {
            return Jalalian::fromFormat(
                'Y/n/j', // استفاده از n و j برای ماه و روز تک‌رقمی یا دورقمی
                "$year/$month/$day"
            )->toCarbon()->format('Y-m-d');
        } catch (\Exception $e) {
            throw new InvalidArgumentException('تاریخ شمسی نامعتبر: ' . $e->getMessage());
        }
    }

    protected function toJalali(string $gDate, string $format = 'Y/m/d'): string
    {
        return Jalalian::fromDateTime($gDate)->format($format);
    }
}
