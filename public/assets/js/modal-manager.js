/**
 * مدیریت مودال‌های متعدد در سیستم
 */
class ModalManager {
    constructor() {
        this.openModals = new Set();
        this.init();
    }

    init() {
        // گوش دادن به کلیدهای صفحه کلید
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeTopModal();
            }
        });

        // گوش دادن به کلیک روی backdrop
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-backdrop')) {
                this.closeTopModal();
            }
        });
    }

    /**
     * باز کردن مودال
     */
    openModal(modalId) {
        // بستن سایر مودال‌ها
        this.closeAllModals();

        // اضافه کردن به فهرست مودال‌های باز
        this.openModals.add(modalId);

        // اعمال تغییرات UI
        this.applyModalOpen();

        console.log(`Modal opened: ${modalId}`);
    }

    /**
     * بستن مودال خاص
     */
    closeModal(modalId) {
        this.openModals.delete(modalId);

        // حذف backdrop مربوط به این مودال
        const backdrop = document.querySelector(`[id*="${modalId}Backdrop"]`);
        if (backdrop) {
            backdrop.remove();
        }

        // اگر هیچ مودالی باز نیست، تنظیمات body را بازگردان
        if (this.openModals.size === 0) {
            this.applyModalClose();
        }

        console.log(`Modal closed: ${modalId}`);
    }

    /**
     * بستن تمام مودال‌ها
     */
    closeAllModals() {
        // بستن تمام مودال‌ها
        this.openModals.forEach(modalId => {
            // ارسال event بسته شدن به Livewire
            if (window.Livewire) {
                window.Livewire.dispatch('close-modal-' + modalId);
            }
        });

        // پاک کردن فهرست
        this.openModals.clear();

        // حذف تمام backdrop ها
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });

        this.applyModalClose();
    }

    /**
     * بستن آخرین مودال باز شده
     */
    closeTopModal() {
        if (this.openModals.size > 0) {
            const lastModal = Array.from(this.openModals).pop();
            this.closeModal(lastModal);
        }
    }

    /**
     * اعمال تنظیمات باز کردن مودال
     */
    applyModalOpen() {
        document.body.classList.add('modal-open');
        document.body.style.paddingRight = '17px';
        document.body.style.overflow = 'hidden';
    }

    /**
     * اعمال تنظیمات بسته کردن مودال
     */
    applyModalClose() {
        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
        document.body.style.overflow = '';
    }

    /**
     * بررسی باز بودن مودال
     */
    isModalOpen(modalId) {
        return this.openModals.has(modalId);
    }

    /**
     * دریافت تعداد مودال‌های باز
     */
    getOpenModalsCount() {
        return this.openModals.size;
    }

    /**
     * دریافت فهرست مودال‌های باز
     */
    getOpenModals() {
        return Array.from(this.openModals);
    }
}

// ایجاد instance سراسری
window.modalManager = new ModalManager();

// Integration با Livewire
document.addEventListener('DOMContentLoaded', function() {

    // گوش دادن به event های Livewire برای باز کردن مودال‌ها
    if (window.Livewire) {

        // مودال جزئیات
        Livewire.on('show-modal-details-changes', () => {
            window.modalManager.openModal('details-changes');
        });

        Livewire.on('hide-modal-details-changes', () => {
            window.modalManager.closeModal('details-changes');
        });

        // مودال ساکن (فرض می‌کنیم این نام را دارد)
        Livewire.on('show-modal-resident', () => {
            window.modalManager.openModal('resident');
        });

        Livewire.on('hide-modal-resident', () => {
            window.modalManager.closeModal('resident');
        });

        // Event عمومی برای بستن تمام مودال‌ها
        Livewire.on('close-all-modals', () => {
            window.modalManager.closeAllModals();
        });
    }

    // Debug information
    console.log('Modal Manager initialized');
});
