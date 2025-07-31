<?php

namespace App\Services\Core;

class StatusService
{
    /**
     * بازگرداندن badge مناسب برای وضعیت پرداخت بر اساس تعداد روزهای باقی مانده
     *
     * @param int $daysSincePayment
     * @return string
     */
    public function getStatusBadge(int $daysSincePayment): string
    {

        if ($daysSincePayment < 0) {
            // پرداخت معوقه
            return '<span class="badge bg-danger">' . abs($daysSincePayment) . '</span>';
        } elseif ($daysSincePayment == 0) {
            // امروز سررسید است
            return '<span class="badge text-dark" style="background-color:#F97A00">امروز سررسید</span>';
        } elseif ($daysSincePayment <= 7) {
            // 4-7 روز باقی مانده
            return '<span class="badge bg-warning">' . $daysSincePayment . '</span>';
        } else {
            // بیش از 7 روز باقی مانده
            return '<span class="badge bg-success">' . $daysSincePayment . '</span>';
        }
    }

    /**
     * بازگرداندن کلاس CSS مناسب برای وضعیت
     *
     * @param int $daysSincePayment
     * @return string
     */
    public function getStatusClass(int $daysSincePayment): string
    {
        if ($daysSincePayment < 0) {
            return 'text-danger';
        } elseif ($daysSincePayment <= 3) {
            return 'text-warning';
        } elseif ($daysSincePayment <= 7) {
            return 'text-info';
        } else {
            return 'text-success';
        }
    }

    /**
     * بازگرداندن متن وضعیت به صورت ساده
     *
     * @param int $daysSincePayment
     * @return string
     */
    public function getStatusText(int $daysSincePayment): string
    {
        if ($daysSincePayment < 0) {
            return 'معوقه ' . abs($daysSincePayment) . ' روز';
        } elseif ($daysSincePayment == 0) {
            return 'امروز سررسید';
        } else {
            return $daysSincePayment . ' روز باقی';
        }
    }

    /**
     * تشخیص اینکه آیا وضعیت بحرانی است یا نه
     *
     * @param int $daysSincePayment
     * @return bool
     */
    public function isCritical(int $daysSincePayment): bool
    {
        return $daysSincePayment <= 3;
    }
}
