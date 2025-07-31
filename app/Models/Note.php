<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'resident_id',
        'type',
        'note'
    ];
    protected $dates = ['deleted_at'];

    // Relations
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * دریافت یادداشت‌ها با فرمت سفارشی برای نمایش در جدول
     * @param string|null $type
     * @return \Illuminate\Support\Collection
     */
    public function getFormattedNotes(?string $type = null)
    {
        $validTypes = ['payment', 'end_date', 'exit', 'demand', 'other'];

        $query = Note::query();

        if ($type) {
            if (!in_array($type, $validTypes)) {
                throw new \InvalidArgumentException("نوع نامعتبر!");
            }
            $query->where('type', $type);
        }

        return $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($note) {
                return $this->formatNote($note);
            });
    }

    /**
     * فرمت‌دهی هر یادداشت
     */
    private function formatNote(Note $note): array
    {
        $formats = [
            'payment' => [
                'icon' => '💸',
                'suffix' => 'پرداخت',
                'status' => '✅ طلب'
            ],
            'end_date' => [
                'icon' => '📅',
                'suffix' => 'تاریخ',
                'status' => '📌 سررسید'
            ],
            'exit' => [
                'icon' => '🚪',
                'suffix' => 'خروج',
                'status' => '⚠️ پایان'
            ],
            'demand' => [
                'icon' => '⏳',
                'suffix' => 'تأخیر',
                'status' => '❌ بدهی'
            ],
            'default' => [
                'icon' => 'ℹ️',
                'suffix' => '',
                'status' => '📝 دیگر'
            ]
        ];

        $format = $formats[$note->type] ?? $formats['default'];

        return [
            'formatted_text' => sprintf(
                "%s %s: %s → %s",
                $format['icon'],
                $format['suffix'],
                $this->extractDateFromNote($note->note), // استخراج تاریخ از متن یادداشت
                $format['status']
            ),
            'raw_data' => $note // داده خام برای استفاده احتمالی
        ];
    }

    /**
     * استخراج تاریخ از متن یادداشت (سفارشی‌سازی بر اساس نیاز شما)
     */
    private function extractDateFromNote(string $noteText): string
    {
        // الگوی ساده برای استخراج تاریخ
        if (preg_match('/(\d{1,2}(ام|م)?\s*(مرداد|شهریور|آبان|آذر|دی|بهمن|اسفند|فروردین|اردیبهشت|خرداد|تیر|مرداد))/', $noteText, $matches)) {
            return $matches[0];
        }

        return 'تاریخ نامشخص';
    }

}
