<?php

namespace App\Services\Report;

use App\Models\Unit;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Resident;
use App\Models\Contract;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    /**
     * آمار کلی تخت‌ها بر اساس وضعیت
     */
    public function getTotalBedStatistics(): array
    {
        $totalBeds = Bed::query()->count();

        $fullBeds = Bed::query()
            ->whereHas('contracts')
            ->count();

        $rezervedBeds = Bed::query()
            ->where('state_ratio_resident', 'rezerve') // Fixed typo in field name if needed
            ->whereHas('contracts') // Beds that are rezerved but don't have contracts
            ->count();

        $emptyBeds = Bed::query()
            ->where('state_ratio_resident', 'empty') // Fixed typo in field name if needed
            ->count();

        return [
            'total' => $totalBeds,
            'full' => $fullBeds,
            'rezerved' => $rezervedBeds,
            'empty' => $emptyBeds,
            'percentage_full' => $totalBeds > 0 ? round(($fullBeds / $totalBeds) * 100, 2) : 0,
            'percentage_empty' => $totalBeds > 0 ? round(($emptyBeds / $totalBeds) * 100, 2) : 0,
        ];
    }

    /**
     * آمار کلی اتاق‌ها
     */
    public function getTotalRoomStatistics(): array
    {
        $totalRooms = Room::count();

        // اتاق‌های کامل (تمام تخت‌ها اشغال)
        $fullRooms = Room::whereHas('beds', function ($query) {
            $query->whereHas('contracts', function ($contractQuery) {
                $contractQuery->where('state', 'active')
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            });
        })->whereDoesntHave('beds', function ($query) {
            $query->whereDoesntHave('contracts', function ($contractQuery) {
                $contractQuery->where('state', 'active')
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            })->whereDoesntHave('rezerves', function ($rezerveQuery) {
                $rezerveQuery->where('state', 'active');
            });
        })->count();

        // اتاق‌های نیمه خالی (حداقل یک تخت اشغال)
        $partialRooms = Room::whereHas('beds', function ($query) {
            $query->whereHas('contracts', function ($contractQuery) {
                $contractQuery->where('state', 'active')
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            });
        })->where('id', 'NOT IN', function ($subQuery) {
            $subQuery->select('rooms.id')
                ->from('rooms')
                ->join('beds', 'rooms.id', '=', 'beds.room_id')
                ->leftJoin('contracts', function ($join) {
                    $join->on('beds.id', '=', 'contracts.bed_id')
                        ->where('contracts.state', '=', 'active')
                        ->whereDate('contracts.start_date', '<=', now())
                        ->whereDate('contracts.end_date', '>=', now());
                })
                ->leftJoin('rezerves', function ($join) {
                    $join->on('beds.id', '=', 'rezerves.bed_id')
                        ->where('rezerves.state', '=', 'active');
                })
                ->whereNull('contracts.id')
                ->whereNull('rezerves.id')
                ->groupBy('rooms.id');
        })->count();

        $emptyRooms = $totalRooms - $fullRooms - $partialRooms;

        return [
            'total' => $totalRooms,
            'full' => $fullRooms,
            'partial' => $partialRooms,
            'empty' => $emptyRooms
        ];
    }

    /**
     * آمار اقامتگران
     */
    public function getResidentStatistics(): array
    {
        $totalResidents = Resident::query()->count();

        // Active residents (with valid contracts)
        $activeResidents = Resident::query()
            ->whereHas('contract', function ($query) {
                $query->where('state', 'active');
            })->count();

        // rezerved residents (nightly)
        $rezervedResidents = Resident::query()
            ->whereHas('contract', function ($query) {
                $query->where('state', 'rezerve');
            })->count();

        // Residents in checkout process
        $checkingOutResidents = Resident::query()
            ->whereHas('contract', function ($query) {
                $query->where('state', 'checking_out');
            })->count();

        // Inactive residents (no valid contracts)
        $nightlyResidents = Resident::query()
            ->whereDoesntHave('contract')
            ->orWhereHas('contract', function ($query) {
                $query->where('state', 'nightly');
            })->count();

        return [
            'total' => $totalResidents,
            'active' => $activeResidents,
            'rezerved' => $rezervedResidents,
            'checking_out' => $checkingOutResidents,
            'nightly' => $nightlyResidents
        ];
    }

    /**
     * آمار تفصیلی بر اساس واحدها (طبقات)
     */
    public function getStatisticsByUnits()
    {
        return Unit::with(['rooms.beds.contracts', 'rooms.beds'])
            ->get()
            ->map(function ($unit) {
                $beds = $unit->rooms->flatMap->beds;
                $totalBeds = $beds->count();

                // تخت‌های فعال (دارای قرارداد فعال)
                $activeBeds = $beds->filter(function ($bed) {
                    return $bed->contracts->whereIn('state', ['active', 'leaving', 'nightly'])->isNotEmpty();
                })->count();

                // تخت‌های رزرو شده (بر اساس state_ratio_resident)
                $rezervedBeds = $beds->where('state_ratio_resident', 'rezerve')->count();

                // تخت‌های در حال خروج (بر اساس state_ratio_resident)
                $leavingBeds = $beds->where('state_ratio_resident', 'leaving')->count();

                // تخت‌های خالی (بدون قرارداد فعال و state_ratio_resident خالی)
                $emptyBeds = $beds->where('state_ratio_resident', 'empty')->count();


                return [
                    'unit_name' => $unit->name,
                    'total_rooms' => $unit->rooms->count(),
                    'beds' => [
                        'total' => $totalBeds,
                        'active' => $activeBeds,
                        'rezerved' => $rezervedBeds,
                        'leaving' => $leavingBeds,
                        'empty' => $emptyBeds,
                        // محاسبه درصدها (اختیاری)
                        'percentages' => $totalBeds > 0 ? [
                            'active' => round(($activeBeds / $totalBeds) * 100, 2),
                            'rezerved' => round(($rezervedBeds / $totalBeds) * 100, 2),
                            'leaving' => round(($leavingBeds / $totalBeds) * 100, 2),
                            'empty' => round(($emptyBeds / $totalBeds) * 100, 2),
                        ] : null,
                    ]
                ];
            });
    }
    /**
     * آمار تفصیلی بر اساس اتاق‌ها در هر واحد
     */
    public function getDetailedStatisticsByRooms()
    {
        return Unit::with(['rooms.beds.contracts', 'rooms.beds.rezerves'])
            ->get()
            ->map(function ($unit) {
                $rooms = $unit->rooms->map(function ($room) {
                    $totalBeds = $room->beds->count();

                    $occupiedBeds = $room->beds->filter(function ($bed) {
                        return $bed->contracts->where('state', 'active')
                                ->where('start_date', '<=', now())
                                ->where('end_date', '>=', now())
                                ->count() > 0;
                    })->count();

                    $rezervedBeds = $room->beds->filter(function ($bed) {
                        return $bed->rezerves->where('state', 'active')->count() > 0;
                    })->count();

                    $emptyBeds = $totalBeds - $occupiedBeds - $rezervedBeds;

                    return [
                        'room_name' => $room->name,
                        'beds' => [
                            'total' => $totalBeds,
                            'occupied' => $occupiedBeds,
                            'rezerved' => $rezervedBeds,
                            'empty' => $emptyBeds
                        ]
                    ];
                });

                return [
                    'unit_name' => $unit->name,
                    'rooms' => $rooms
                ];
            });
    }

    /**
     * آمار کامل برای نمایش در کامپوننت
     */
    public function
    getAllStatistics(): array
    {
        return [
            'bed_statistics' => $this->getTotalBedStatistics(),
            'room_statistics' => $this->getTotalRoomStatistics(),
            'resident_statistics' => $this->getResidentStatistics(),
            'unit_statistics' => $this->getStatisticsByUnits(),
            'detailed_room_statistics' => $this->getDetailedStatisticsByRooms()
        ];
    }
}
