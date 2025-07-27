<?php

namespace App\Traits;

use Livewire\Attributes\On;

trait HasModalManagement
{
    public $showModal = false;
    public $modalId = '';

    /**
     * باز کردن مودال با شناسه منحصر به فرد
     */
    protected function openModalWithId(string $modalId, callable $loadDataCallback = null): void
    {
        // بستن سایر مودال‌ها
        $this->dispatch('close-all-modals');

        $this->modalId = $modalId;
        $this->showModal = true;

        // اجرای callback برای بارگذاری داده‌ها
        if ($loadDataCallback) {
            $loadDataCallback();
        }

        // ارسال event با شناسه منحصر به فرد
        $this->dispatch('show-modal-' . $modalId);
    }

    /**
     * بستن مودال
     */
    protected function closeModalWithId(): void
    {
        $modalId = $this->modalId;
        $this->showModal = false;
        $this->modalId = '';

        // پاکسازی خصوصیات (باید در کلاس فرزند تعریف شود)
        if (method_exists($this, 'resetModalProperties')) {
            $this->resetModalProperties();
        }

        // ارسال event بسته شدن
        $this->dispatch('hide-modal-' . $modalId);
    }

    /**
     * Listener برای بستن تمام مودال‌ها
     */
    #[On('close-all-modals')]
    public function closeAllModals(): void
    {
        if ($this->showModal) {
            $this->closeModalWithId();
        }
    }

    /**
     * بررسی باز بودن مودال
     */
    public function isModalOpen(): bool
    {
        return $this->showModal;
    }

    /**
     * دریافت شناسه مودال
     */
    public function getModalId(): string
    {
        return $this->modalId;
    }
}
