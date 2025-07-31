<?php

// app/Repositories/NoteRepository.php
namespace App\Repositories;

use App\Models\Note;
use App\Enums\NoteType;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository
{
    protected $model;

    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    public function create(array $data): Note
    {
        return $this->model->create($data);
    }

    public function getByResident(int $residentId, NoteType|string|null $type = null): Collection
    {
        $query = $this->model->where('resident_id', $residentId);

        if ($type) {
            $query->where('type', $type);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getPaymentNotes(int $residentId): Collection
    {
        return $this->getByResident($residentId, NoteType::PAYMENT);
    }

    public function getLatestNotes(int $limit = 5): Collection
    {
        return $this->model->with('resident')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }


    public function formatNoteForDisplay(array $noteArray): string
    {
        $type = $noteArray['type'] ?? 'other';
        $noteText = $noteArray['note'] ?? '';
        $formats = [

            'end_date' => [
                'icon' => '📅',
                'prefix' => 'سررسید',
                'status' => '📌 سررسید'
            ],
            'payment' => [
                'icon' => '💸',
                'prefix' => 'پرداخت',
                'status' => '✅ بدهی'
            ],
            'exit' => [
                'icon' => '🚪',
                'prefix' => 'خروج',
                'status' => '⚠️ پایان'
            ],
            'demand' => [
                'icon' => '⏳',
                'prefix' => 'طلب',
                'status' => '❌ طلب'
            ],
            'other' => [
                'icon' => 'ℹ️',
                'prefix' => '',
                'status' => '📝 دیگر'
            ]
        ];

        $format = $formats[$type] ?? $formats['other'];

        return sprintf(
            "%s %s ::  %s ",
            $format['icon'],
            $format['prefix'],
            $this->cleanNoteText($noteText),
        );
    }

    /**
     * پاکسازی متن یادداشت برای نمایش بهتر
     */
    private function cleanNoteText(string $noteText): string
    {
        // حذف فاصله‌های اضافه
        $cleaned = trim($noteText);

        // تبدیل اعداد فارسی به انگلیسی (در صورت نیاز)
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $cleaned = str_replace($persianNumbers, $englishNumbers, $cleaned);

        return $cleaned;
    }
}
