<?php

namespace App\Livewire\Pages\Coolers;

use App\Models\Cooler;
use App\Models\Room;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CoolerRoomManager extends Component
{
    public $coolers;
    public $rooms;
    public $units;
    public $connections = [];

    // Form properties
    public $selectedCooler = null;
    public $selectedRoom = null;
    public $connectionType = 'direct';
    public $connectedAt = '';
    public $notes = '';

    //Details Cooler
    public $selectedNameCoolerModal = null;
    public $selectedNumberCoolerModal = null;
    public $descDetailsCoolerModal = null;
    public $showDetailsCoolerModal = false;
    public $editingDetailsCoolerModal = false;
    public $idDetailsCoolerModal = null;


    // Modal states
    public $showConnectionModal = false;
    public $editingConnection = null;

    // Search and filter
    public $searchCooler = '';
    public $searchRoom = '';
    public $filterUnit = '';
    public $filterStatus = '';


// listener برای تایید حذف
    protected $listeners = ['delete-confirmed' => 'deleteConnection'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->coolers = Cooler::with('rooms')->get();
        $this->rooms = Room::with(['unit', 'coolers'])->get();
        $this->units = Unit::all();
        $this->loadConnections();
    }

    public function loadConnections()
    {
        $this->connections = Cooler::with('rooms')->get();
//        dd($this->connections);
    }

    public function openConnectionModal($coolerId = null, $roomId = null)
    {
        $this->resetForm();
        $this->selectedCooler = $coolerId;
        $this->selectedRoom = $roomId;
        $this->connectedAt = now()->format('Y-m-d');
        $this->showConnectionModal = true;
    }

    public function editConnection($connectionId)
    {

        $connection = DB::table('cooler_room')->find($connectionId);
        if ($connection) {
            $this->editingConnection = $connectionId;
            $this->selectedCooler = $connection->cooler_id;
            $this->selectedRoom = $connection->room_id;
            $this->connectionType = $connection->connection_type;
            $this->connectedAt = $connection->connected_at;
            $this->notes = $connection->notes;
            $this->showConnectionModal = true;
        }
    }

    public function saveConnection(): void
    {
        // اگر selectedRoom آرایه باشد، آن را به آرایه تبدیل کنید
        $roomIds = $this->editingConnection ? [$this->selectedRoom] : (is_array($this->selectedRoom) ? $this->selectedRoom : [$this->selectedRoom]);

        // اعتبارسنجی
        $rules = [
            'selectedCooler' => 'required|exists:coolers,id',
            'notes' => 'nullable|string|max:500',
            'connectedAt' => 'nullable|date',
        ];

        if ($this->editingConnection) {
            $rules['selectedRoom'] = 'required|exists:rooms,id';
        } else {
            $rules['selectedRoom'] = 'required|array';
            $rules['selectedRoom.*'] = 'exists:rooms,id';
        }

        $this->validate($rules);

        try {
            if ($this->editingConnection) {
                // Update existing connection
                DB::table('cooler_room')
                    ->where('id', $this->editingConnection)
                    ->update([
                        'cooler_id' => $this->selectedCooler,
                        'room_id' => $this->selectedRoom,
                        'connection_type' => $this->connectionType,
                        'connected_at' => $this->connectedAt,
                        'notes' => $this->notes,
                        'updated_at' => now()
                    ]);

                $this->dispatch('show-toast', [
                    'type' => 'info',
                    'title' => 'Updated!',
                    'description' => 'اتصال اپدیت شد',
                    'timer' => 3000
                ]);
            } else {
                // Create new connections for each room
                foreach ($roomIds as $roomId) {
                    // بررسی وجود اتصال تکراری
                    $exists = DB::table('cooler_room')
                        ->where('cooler_id', $this->selectedCooler)
                        ->where('room_id', $roomId)
                        ->exists();

                    if ($exists) {
                        $this->dispatch('show-toast', [
                            'type' => 'error',
                            'title' => 'خطا!',
                            'description' => "اتصال برای اتاق $roomId قبلاً وجود دارد!",
                            'timer' => 3000
                        ]);
                        continue;
                    }

                    DB::table('cooler_room')->insert([
                        'cooler_id' => $this->selectedCooler,
                        'room_id' => $roomId,
                        'connection_type' => $this->connectionType,
                        'connected_at' => count($roomIds) === 1 ? $this->connectedAt : null,
                        'notes' => count($roomIds) === 1 ? $this->notes : null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'title' => 'Created!',
                    'description' => 'اتصال(های) جدید ایجاد شد!',
                    'timer' => 3000
                ]);
            }

            $this->closeConnectionModal();
            $this->loadData();
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'title' => 'خطا!',
                    'description' => 'اتصال تکراری است!',
                    'timer' => 3000
                ]);
            } else {
                $this->dispatch('show-toast', [
                    'type' => 'error',
                    'title' => 'خطا!',
                    'description' => 'خطایی رخ داد: ' . $e->getMessage(),
                    'timer' => 3000
                ]);
            }
        }
    }

    public function confirmDelete($connectionId)
    {

        $this->dispatch('confirmDelete', ['connectionId' => $connectionId]);

    }

    public function deleteConnection($connectionId)
    {
        DB::table('cooler_room')->where('id', $connectionId)->delete();

        $this->dispatch('show-toast', [ // !!! تغییر به 'show-toast'
            'type' => 'error',
            'title' => 'Deleted!',
            'description' => "حذف شد !",
            'timer' => 3000 // Toast پس از 3 ثانیه ناپدید می‌شود
        ]);
        $this->loadData();
    }

    public function closeConnectionModal()
    {
        $this->showConnectionModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->selectedCooler = null;
        $this->selectedRoom = null;
        $this->connectionType = 'direct';
        $this->connectedAt = '';
        $this->notes = '';
        $this->editingConnection = null;

        //Details Cooler
        $this->selectedNameCoolerModal = null;
        $this->selectedNumberCoolerModal = null;
        $this->descDetailsCoolerModal = null;
        $this->idDetailsCoolerModal = null;
    }

    public function getFilteredCoolersProperty()
    {
        return $this->coolers->when($this->searchCooler, function ($query) {
            return $query->filter(function ($cooler) {
                return str_contains(strtolower($cooler->name), strtolower($this->searchCooler)) ||
                    str_contains($cooler->number ?? '', $this->searchCooler);
            });
        })->when($this->filterStatus, function ($query) {
            return $query->where('status', $this->filterStatus);
        });
    }

    public function getFilteredRoomsProperty()
    {
        return $this->rooms->when($this->searchRoom, function ($query) {
            return $query->filter(function ($room) {
                return str_contains(strtolower($room->name), strtolower($this->searchRoom)) ||
                    str_contains($room->code ?? '', $this->searchRoom);
            });
        })->when($this->filterUnit, function ($query) {
            return $query->where('unit_id', $this->filterUnit);
        });
    }


    /** here add and edit coolers */


    public function openDetailsCoolerModal($coolerId = null)
    {
        $this->resetForm();
        if ($coolerId) {
            $cooler = Cooler::find($coolerId);
            $this->selectedNameCoolerModal = $cooler->name;
            $this->selectedNumberCoolerModal = $cooler->number;
            $this->descDetailsCoolerModal = $cooler->desc;
            $this->idDetailsCoolerModal = $cooler->id;

            $this->editingDetailsCoolerModal = true;
            $this->showDetailsCoolerModal = true;
        } else {
            $this->editingDetailsCoolerModal = false;
            $this->showDetailsCoolerModal = true;
        }

    }

    public function saveDetailsCoolerModal($coolerId = null): void
    {
        $this->validate([
            'selectedNameCoolerModal' => 'required',
            'selectedNumberCoolerModal' => 'required',
        ]);

        if (isset($coolerId) && !is_null($coolerId)) {
            // حالت ویرایش
            $cooler = Cooler::findOrFail($coolerId);

            $cooler->update([
                'name' => $this->selectedNameCoolerModal,
                'number' => $this->selectedNumberCoolerModal,
                'desc' => $this->descDetailsCoolerModal,
            ]);

            $this->dispatch('show-toast', [ // !!! تغییر به 'show-toast'
                'type' => 'info',
                'title' => 'Updated!',
                'description' => $this->selectedNameCoolerModal . ' آپدیت شد ',
                'timer' => 3000 // Toast پس از 3 ثانیه ناپدید می‌شود
            ]);

        } else {

            // حالت اضافه کردن
            $cooler = Cooler::create([
                'name' => $this->selectedNameCoolerModal,
                'number' => $this->selectedNumberCoolerModal,
                'desc' => $this->descDetailsCoolerModal,
                'status' => 'active', // وضعیت پیش‌فرض
            ]);

            // پیام موفقیت
            $this->dispatch('show-toast', [ // !!! تغییر به 'show-toast'
                'type' => 'success',
                'title' => 'Created!',
                'description' => $this->selectedNameCoolerModal . ' درست شد ',
                'timer' => 3000 // Toast پس از 3 ثانیه ناپدید می‌شود
            ]);

        }

        // پاک کردن فیلدها و بستن مودال
        $this->resetForm();
        $this->showDetailsCoolerModal = false;
        $this->loadData();
//
    }

    public function editDetailsCoolerModal($coolerId = null)
    {
        dd($coolerId);
    }

    public function closeDetailsCoolerModal()
    {
        $this->showDetailsCoolerModal = false;
        $this->resetForm();
    }

    public function confirmDeleteCooler($coolerId): void
    {
        $cooler = Cooler::find($coolerId);
        $coolerName = $cooler->name;

        $this->js("
        cuteAlert({
            type: 'warning',
            title: 'حذف کولر',
            description: 'آیا از حذف کولر \\'$coolerName\\' مطمئن هستید؟ این عمل قابل بازگشت نیست.',
            primaryButtonText: 'بله، حذف کن',
            secondaryButtonText: 'انصراف'
        }).then((result) => {
            if (result === 'primaryButtonClicked') {
                \$wire.deleteCooler($coolerId);
            }
        });
    ");
    }

    public function deleteCooler($coolerId): void
    {
        try {
            $cooler = Cooler::findOrFail($coolerId);
            $coolerName = $cooler->name;

            $cooler->rooms()->detach();
            $cooler->delete();

            $this->js("
                cuteToast({
                    type: 'error',
                    title: 'Deleted!',
                    description: 'حذف کولر ',
                    timer: 5000
                })
            ");

            $this->loadData();
        } catch (\Exception $e) {
            $this->js("
                cuteToast({
                    type: 'error',
                    title: 'Deleted!',
                    description: 'عملیات حذف با موفقیت صورت نگرفت',
                    timer: 5000
                })
            ");
        }
    }

    public function render()
    {
        return view('livewire.pages.coolers.cooler-room-manager')
            ->title("مدیریت کولر ها");
    }
}
