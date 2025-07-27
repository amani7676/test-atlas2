<?php

namespace App\Services\Core;

class ModalManagerService
{
    /**
     * فهرست مودال‌های باز
     */
    private static array $openModals = [];

    /**
     * باز کردن مودال
     */
    public static function openModal(string $modalId): void
    {
        // بستن سایر مودال‌ها
        self::closeAllModals();

        // باز کردن مودال جدید
        self::$openModals[$modalId] = true;
    }

    /**
     * بستن مودال خاص
     */
    public static function closeModal(string $modalId): void
    {
        unset(self::$openModals[$modalId]);
    }

    /**
     * بستن تمام مودال‌ها
     */
    public static function closeAllModals(): void
    {
        self::$openModals = [];
    }

    /**
     * بررسی باز بودن مودال
     */
    public static function isModalOpen(string $modalId): bool
    {
        return isset(self::$openModals[$modalId]) && self::$openModals[$modalId];
    }

    /**
     * دریافت فهرست مودال‌های باز
     */
    public static function getOpenModals(): array
    {
        return array_keys(self::$openModals);
    }

    /**
     * بررسی اینکه آیا هیچ مودالی باز نیست
     */
    public static function hasNoOpenModals(): bool
    {
        return empty(self::$openModals);
    }
}
