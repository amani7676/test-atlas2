<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PersianDate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{4}\/\d{1,2}\/\d{1,2}$/', $value)) {
            $fail('فرمت تاریخ معتبر نیست (فرمت صحیح: 1404/04/04)');
            return;
        }

        [$year, $month, $day] = explode('/', $value);

        // تبدیل به عدد
        $y = (int) $year;
        $m = (int) $month;
        $d = (int) $day;

        // اعتبارسنجی محدوده‌ها
        if ($y < 1300 || $y > 1500) {
            $fail('سال باید بین ۱۳۰۰ تا ۱۵۰۰ باشد');
        }

        if ($m < 1 || $m > 12) {
            $fail('ماه باید بین ۱ تا ۱۲ باشد');
        }

        if ($d < 1 || $d > 31) {
            $fail('روز باید بین ۱ تا ۳۱ باشد');
        }

        // اعتبارسنجی روزهای خاص ماه
        if ($m > 6 && $d > 30) {
            $fail("ماه $month حداکثر ۳۰ روز دارد");
        }

        // اعتبارسنجی اسفند (ماه 12)
        if ($m == 12) {
            $isLeap = ($y % 4 == 3); // سال کبیسه شمسی (تقریبی)
            if (($isLeap && $d > 30) || (!$isLeap && $d > 29)) {
                $fail('اسفند حداکثر ۲۹ روز دارد (۳۰ روز در سال کبیسه)');
            }
        }
    }
}
