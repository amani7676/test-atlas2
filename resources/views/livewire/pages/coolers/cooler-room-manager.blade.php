<div>
    <div class="container-fluid py-4" dir="rtl">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="text-primary mb-1">
                                    <i class="fas fa-wind me-2"></i>
                                    مدیریت اتصال کولرها به اتاق‌ها
                                </h4>
                                <p class="text-muted mb-0">تعریف و مدیریت ارتباطات بین کولرها و اتاق‌ها</p>
                            </div>
                            <button class="btn btn-success btn-lg" wire:click="openConnectionModal">
                                <i class="fas fa-plus me-2"></i>
                                اتصال جدید
                            </button>

                            <button class="btn btn-info btn-lg" wire:click="openDetailsCoolerModal()">
                                <i class="fas fa-plus me-2"></i>
                               کولر
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Main Grid Layout --}}
        <div class="row">

            {{-- Coolers Section --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm ">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-wind me-2"></i>
                            کولرها
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        {{-- Search Box --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="جستجوی کولر..."
                                       wire:model.live="searchCooler">
                                <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            </div>
                        </div>

                        {{-- Status Filter --}}
                        <div class="mb-3">
                            <select class="form-select" wire:model.live="filterStatus">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="active">فعال</option>
                                <option value="inactive">غیرفعال</option>
                                <option value="maintenance">تعمیرات</option>
                            </select>
                        </div>

                        {{-- Coolers List --}}
                        <div class="coolers-list" style="max-height: 170px; overflow-y: auto;">
                            @forelse($this->filteredCoolers as $cooler)
                                <div class="card mb-2 border-start border-4 border-warning">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="card-title mb-1">{{ $cooler->name }}</h6>
                                                @if($cooler->number)
                                                    <small class="text-muted">شماره: {{ $cooler->number }}</small>
                                                @endif
                                                <div class="mt-2">
                                                <span class="badge bg-{{
                                                    $cooler->status === 'active' ? 'success' :
                                                    ($cooler->status === 'inactive' ? 'secondary' : 'warning')
                                                }}">
                                                    {{
                                                        $cooler->status === 'active' ? 'فعال' :
                                                        ($cooler->status === 'inactive' ? 'غیرفعال' : 'تعمیرات')
                                                    }}
                                                </span>
                                                </div>
                                                <small class="text-primary mt-1 d-block">
                                                    اتصالات: {{ $cooler->rooms->count() }}
                                                </small>
                                            </div>
                                            <button class="btn btn-outline-primary btn-sm"
                                                    wire:click="openConnectionModal({{ $cooler->id }})">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-wind fa-3x mb-3"></i>
                                    <p>کولری یافت نشد</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rooms Section --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm ">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-door-open me-2"></i>
                            اتاق‌ها
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        {{-- Search Box --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="جستجوی اتاق..."
                                       wire:model.live="searchRoom">
                                <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            </div>
                        </div>

                        {{-- Unit Filter --}}
                        <div class="mb-3">
                            <select class="form-select" wire:model.live="filterUnit">
                                <option value="">همه واحدها</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Rooms List --}}
                        <div class="rooms-list" style="max-height: 170px; overflow-y: auto;">
                            @forelse($this->filteredRooms as $room)
{{--                                {{ dd($room->coolers[0]->number) }}--}}
                                <div class="card mb-2 border-start border-4 border-success">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h3 class="card-title mb-1">{{ $room->name }}</h3>
                                                @if($room->code)
                                                    <small class="text-muted">کد: {{ $room->code }}</small>
                                                @endif
                                                <div class="mt-2">
                                                    <small class="text-info d-block">
                                                        <i class="fas fa-building me-1"></i>
                                                        {{ $room->unit->name }}
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-bed me-1"></i>
                                                        {{ $room->bed_count }} تخت
                                                    </small>
                                                </div>
                                                <h5 class="text-primary mt-1 d-block">
                                                    کولر شماره: {{ optional($room->coolers->first())->number ?? 'ندارد' }}
                                                </h5>
                                            </div>
                                            <button class="btn btn-outline-success btn-sm"
                                                    wire:click="openConnectionModal(null, {{ $room->id }})">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-door-open fa-3x mb-3"></i>
                                    <p>اتاقی یافت نشد</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Connections Section --}}
            <div class="col-lg-12 mb-4">
                @foreach($connections as $connection)
                    <div class="card border-0 shadow-sm ">
                        <div class="card-header text-white" style="background-color: #77BEF0">
                            <h5 class="mb-0">
                                <i class="fas fa-link me-2"></i>
                                {{ $connection->name }}
                            </h5>
                            <button class="btn btn-outline-primary" wire:click="openDetailsCoolerModal({{$connection->id}})">Edit</button>
                            <button class="btn btn-outline-danger" style="margin-right: 10px" wire:click="confirmDeleteCooler({{$connection->id}})">Delete</button>
                        </div>
                        <div class="card-body p-1 m-1">
                            <div class="row" >

                                @forelse($connection->rooms as $item)
                                    <div class="col-2">
                                        <div class="card mt-3 border-start border-4 border-info">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="flex-grow-1">
                                                        <h6 class="text-primary mb-1">
                                                            <i class="fas fa-wind me-1"></i>
                                                            {{ $connection->name }}
                                                        </h6>
                                                        <h3 class="text-success mb-1">
                                                            <i class="fas fa-door-open me-1"></i>
                                                            {{ $item->name }}
                                                        </h3>
                                                        <span class="badge bg-{{
                                                            $item->pivot->connection_type === 'direct' ? 'success' :
                                                            ($item->pivot->connection_type === 'duct' ? 'info' : 'warning')
                                                            }} me-2">
                                                                {{
                                                                $item->pivot->connection_type === 'direct' ? 'مستقیم' :
                                                                ($item->pivot->connection_type === 'duct' ? 'کانالی' : 'مرکزی')
                                                                }}
                                                        </span>

                                                    </div>
                                                    <div class="">

                                                        <a class="dropdown-item" href="#"
                                                           wire:click="editConnection({{ $item->pivot->id }})">
                                                            <i class="fas fa-edit me-2"></i>ویرایش
                                                        </a>

                                                        <a class="dropdown-item text-danger" href="#"
                                                           wire:click.prevent="confirmDelete({{ $item->pivot->id }})">
                                                            <i class="fas fa-trash me-2"></i>حذف
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="connection-details">
                                                    @if($item->pivot->notes)
                                                        <small class="text-muted d-block mt-1">
                                                            <i class="fas fa-sticky-note me-1"></i>
                                                            {{ $item->pivot->notes }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty

                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-link fa-3x mb-3"></i>
                                        <p>اتصالی تعریف نشده است</p>
                                    </div>
                                @endforelse


                            </div>
                        </div>
                    </div>
                @endforeach

            </div>


        </div>

        {{-- Connection Modal --}}
        @if($showConnectionModal)
            <div class="modal fade show d-block " tabindex="-1" style="background-color: rgba(0,0,0,0.5); margin-top: 3%">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-link me-2"></i>
                                {{ $editingConnection ? 'ویرایش اتصال' : 'اتصال جدید' }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white"
                                    wire:click="closeConnectionModal"></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="saveConnection">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">کولر</label>
                                        <select class="form-select @error('selectedCooler') is-invalid @enderror"
                                                wire:model="selectedCooler" >
                                            <option value="">انتخاب کولر...</option>
                                            @foreach($coolers as $cooler)
                                                <option value="{{ $cooler->id }}">
                                                    {{ $cooler->name }}
                                                    @if($cooler->number)
                                                        ({{ $cooler->number }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('selectedCooler')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">اتاق</label>
                                        <select class="form-select @error('selectedRoom') is-invalid @enderror"
                                                wire:model="selectedRoom" @if(!$editingConnection) multiple @endif>
                                            <option value="">انتخاب اتاق...</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->id }}">
                                                    {{ $room->name }} - {{ $room->unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('selectedRoom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">نوع اتصال</label>
                                        <select class="form-select @error('connectionType') is-invalid @enderror"
                                                wire:model="connectionType">
                                            <option value="direct">مستقیم</option>
                                            <option value="duct">کانالی</option>
                                            <option value="central">مرکزی</option>
                                        </select>
                                        @error('connectionType')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاریخ اتصال</label>
                                        <input type="date"
                                               class="form-control @error('connectedAt') is-invalid @enderror"
                                               wire:model="connectedAt">
                                        @error('connectedAt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label">یادداشت</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                                  rows="3" placeholder="یادداشت اختیاری..."
                                                  wire:model="notes"></textarea>
                                        @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeConnectionModal">
                                انصراف
                            </button>
                            <button type="button" class="btn btn-primary" wire:click="saveConnection">
                                <i class="fas fa-save me-2"></i>
                                {{ $editingConnection ? 'ویرایش' : 'ذخیره' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- Connection Modal --}}
        @if($showDetailsCoolerModal)
            <div class="modal fade show d-block " tabindex="-1" style="background-color: rgba(0,0,0,0.5); margin-top: 3%">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-link me-2"></i>
                                {{ $editingDetailsCoolerModal ? 'ویرایش کولر' : 'کولر جدید' }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white"
                                    wire:click="closeDetailsCoolerModal"></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="saveDetailsCoolerModal">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">نام</label>
                                        <input wire:model="selectedNameCoolerModal" class="form-control" @error('selectedNameCoolerModal') is-invalid @enderror">
                                        @error('selectedNameCoolerModal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">شماره</label>
                                        <input wire:model="selectedNumberCoolerModal" class="form-control" @error('selectedNumberCoolerModal') is-invalid @enderror">
                                        @error('selectedNumberCoolerModal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-12 mb-3">
                                        <label class="form-label">یادداشت</label>
                                        <textarea class="form-control @error('descDetailsCoolerModal') is-invalid @enderror"
                                                  rows="3" placeholder="یادداشت اختیاری..."
                                                  wire:model="descDetailsCoolerModal"></textarea>
                                        @error('descDetailsCoolerModal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeDetailsCoolerModal">
                                انصراف
                            </button>
                            <button type="button" class="btn btn-primary" wire:click="saveDetailsCoolerModal({{ $idDetailsCoolerModal }})">
                                <i class="fas fa-save me-2"></i>
                                {{ $editingDetailsCoolerModal ? 'ویرایش' : 'ذخیره' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1) !important;
            }

            .connections-list::-webkit-scrollbar,
            .coolers-list::-webkit-scrollbar,
            .rooms-list::-webkit-scrollbar {
                width: 6px;
            }

            .connections-list::-webkit-scrollbar-track,
            .coolers-list::-webkit-scrollbar-track,
            .rooms-list::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .connections-list::-webkit-scrollbar-thumb,
            .coolers-list::-webkit-scrollbar-thumb,
            .rooms-list::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 10px;
            }

            .connections-list::-webkit-scrollbar-thumb:hover,
            .coolers-list::-webkit-scrollbar-thumb:hover,
            .rooms-list::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            .border-start {
                border-left-width: 4px !important;
            }

            .modal.show {
                animation: fadeIn 0.3s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
        </style>
    @endpush
    @script
    <script>
        Livewire.on('confirmDelete', (data) => {
            console.log(data[0].connectionId);
            cuteAlert({
                type: 'warning',
                title: 'حذف اتاق کولر دار',
                description: 'ایا از حذف اتاقی که به کولر وصل است مطمن هستد؟',
                timer: 5000,
                primaryButtonText: 'Confirm',
                secondaryButtonText: 'Cancel'
            }).then((e) => {
                if (e === "primaryButtonClicked") {
                    Livewire.dispatch('delete-confirmed', { connectionId: data[0].connectionId });
                }
            });
        });


        // !!! گوش دادن به رویداد 'show-toast'
        window.addEventListener('show-toast', (event) => {
            const params = event.detail[0];

            // !!! فراخوانی cuteToast به جای cuteAlert
            if (typeof window.cuteToast === 'function') {
                cuteToast({
                    type: params.type,
                    title: params.title,
                    description: params.description,
                    timer: params.timer // timer در Toast ضروری است
                });
            } else {
                console.error('cuteToast function is not available on window object.');
            }
        });



    </script>
    @endscript

</div>
