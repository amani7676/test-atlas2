<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dormitoryeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            // داده‌های واحدها و اتاق‌ها
            $unitsData = [
                "واحد 1" => [
                    "101" => 4, "102" => 8, "103" => 6, "104" => 4, "105" => 4,
                    "106" => 4, "107" => 2, "108" => 2, "109" => 6, "110" => 4
                ],
                "واحد 2" => [
                    "201" => 6, "202" => 6, "203" => 6, "204" => 4, "205" => 4,
                    "206" => 6, "207" => 4, "208" => 4, "209" => 4, "210" => 2
                ],
                "واحد 3" => [
                    "301" => 6, "302" => 6, "303" => 6, "304" => 4, "305" => 4,
                    "306" => 4, "307" => 4, "308" => 4, "309" => 6, "310" => 6,
                    "311" => 2, "312" => 6
                ],
                "واحد 4" => [
                    "401" => 6, "402" => 6, "403" => 6, "404" => 4, "405" => 4,
                    "406" => 6, "407" => 4, "408" => 4, "409" => 4, "410" => 2,
                    "411" => 6
                ]
            ];

            // ایجاد واحدها
            foreach ($unitsData as $unitName => $rooms) {
                preg_match('/\d+/', $unitName, $matches);

                // ایجاد واحد
                $unitId = DB::table('units')->insertGetId([
                    'name' => $unitName,
                    'code' => $matches[0],
                    'desc' => "واحد خوابگاهی {$unitName}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // ایجاد اتاق‌های هر واحد
                foreach ($rooms as $roomNumber => $bedCount) {
                    $roomId = DB::table('rooms')->insertGetId([
                        'unit_id' => $unitId,
                        'name' => "اتاق {$roomNumber}",
                        'bed_count' => $bedCount,
                        'desc' => '',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // ایجاد تخت‌های هر اتاق
                    for ($bedNumber = 1; $bedNumber <= $bedCount; $bedNumber++) {
                        DB::table('beds')->insert([
                            'room_id' => $roomId,
                            'name' => "تخت {$bedNumber} - اتاق {$roomNumber}",
                            'state' => 'active',
                            'state_ratio_resident' => 'empty', // تخت خالی
                            'desc' => "تخت شماره {$bedNumber} در اتاق {$roomNumber} واحد {$unitName}",
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            // نمایش آمار
            $totalUnits = DB::table('units')->count();
            $totalRooms = DB::table('rooms')->count();
            $totalBeds = DB::table('beds')->count();

            $this->command->info("✅ سیدر با موفقیت اجرا شد:");
            $this->command->info("📋 تعداد واحدها: {$totalUnits}");
            $this->command->info("🏠 تعداد اتاق‌ها: {$totalRooms}");
            $this->command->info("🛏️ تعداد تخت‌ها: {$totalBeds}");

            // آمار تفصیلی هر واحد
            $units = DB::table('units')->get();
            foreach ($units as $unit) {
                $roomCount = DB::table('rooms')->where('unit_id', $unit->id)->count();
                $bedCount = DB::table('beds')
                    ->join('rooms', 'beds.room_id', '=', 'rooms.id')
                    ->where('rooms.unit_id', $unit->id)
                    ->count();

                $this->command->info("   {$unit->name}: {$roomCount} اتاق، {$bedCount} تخت");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ خطا در اجرای سیدر: " . $e->getMessage());
            throw $e;
        }
    }
}
