<div>


    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-primary fw-bold mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    آمار تخت‌ها و اقامتگران
                </h2>
                <button wire:click="refresh" class="btn btn-outline-primary"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-sync-alt me-1"></i>
                        به‌روزرسانی
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin me-1"></i>
                        در حال بارگیری...
                    </span>
                </button>
            </div>
        </div>
    </div>

    @if($loading)
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">در حال بارگیری...</span>
            </div>
            <p class="mt-3 text-muted">در حال بارگیری آمار...</p>
        </div>
    @else
        <!-- آمار کلی -->
        <div class="row mb-5">
            <!-- آمار تخت‌ها -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bed me-2"></i>
                            آمار کلی تخت‌ها
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($statistics['bed_statistics']))
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="bg-light rounded p-3">
                                        <h4 class="text-primary mb-1">{{ number_format($statistics['bed_statistics']['total']) }}</h4>
                                        <small class="text-muted">کل تخت‌ها</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="bg-success bg-opacity-10 rounded p-3">
                                        <h4 class="text-success mb-1">{{ number_format($statistics['bed_statistics']['full']) }}</h4>
                                        <small class="text-muted">کل اقامتگران</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-warning bg-opacity-10 rounded p-3">
                                        <h4 class="text-warning mb-1">{{ number_format($statistics['bed_statistics']['rezerved']) }}</h4>
                                        <small class="text-muted">رزرو</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-info bg-opacity-10 rounded p-3">
                                        <h4 class="text-info mb-1">{{ number_format($statistics['bed_statistics']['empty']) }}</h4>
                                        <small class="text-muted">خالی</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- آمار اتاق‌ها -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-door-open me-2"></i>
                            آمار کلی اتاق‌ها
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($statistics['room_statistics']))
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="bg-light rounded p-3">
                                        <h4 class="text-primary mb-1">{{ number_format($statistics['room_statistics']['total']) }}</h4>
                                        <small class="text-muted">کل اتاق‌ها</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="bg-danger bg-opacity-10 rounded p-3">
                                        <h4 class="text-danger mb-1">تعین نشده</h4>
                                        <small class="text-muted">کامل</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-warning bg-opacity-10 rounded p-3">
                                        <h4 class="text-warning mb-1">تعیین نشده</h4>
                                        <small class="text-muted">نیمه خالی</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-info bg-opacity-10 rounded p-3">
                                        <h4 class="text-info mb-1">تعیین نشده</h4>
                                        <small class="text-muted">خالی</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- آمار اقامتگران -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users me-2"></i>
                            آمار اقامتگران
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($statistics['resident_statistics']))
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class=" rounded p-3 " style="background-color: #3D365C">
                                        <h4 class="text-primary mb-1 text-light">{{ number_format($statistics['resident_statistics']['total']) }}</h4>
                                        <small class=" text-light">کل اقامتگران</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="rounded p-3" style="background-color: #93DA97">
                                        <h4 class="text-primary mb-1">{{ number_format($statistics['resident_statistics']['active']) }}</h4>
                                        <small class="text-muted"> فعال</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-opacity-10 rounded p-3" style="background-color: #A2AF9B">
                                        <h4 class="text-success mb-1">{{ number_format($statistics['resident_statistics']['rezerved']) }}</h4>
                                        <small class="text-muted">رزرو</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-secondary bg-opacity-60 rounded p-3 text-light">
                                        <h4 class="text-light mb-1">{{ number_format($statistics['resident_statistics']['nightly']) }}</h4>
                                        <small class="text-light">شبانه</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- آمار بر اساس واحدها -->
        @if(isset($statistics['unit_statistics']) && $statistics['unit_statistics']->count() > 0)
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-building me-2"></i>
                                آمار بر اساس واحدها (طبقات)
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                    <tr>
                                        <th>نام واحد</th>
                                        <th>تعداد اتاق</th>
                                        <th>کل تخت‌ها</th>
                                        <th>فعال</th>
                                        <th>رزرو</th>
                                        <th>خالی</th>
                                        <th>درصد فعال</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($statistics['unit_statistics'] as $unit)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $unit['unit_name'] }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ number_format($unit['total_rooms']) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ number_format($unit['beds']['total']) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ number_format($unit['beds']['active']) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ number_format($unit['beds']['rezerved']) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ number_format($unit['beds']['empty']) }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $percentage = $unit['beds']['total'] > 0
                                                        ? round(($unit['beds']['active'] / $unit['beds']['total']) * 100, 1)
                                                        : 0;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success"
                                                         style="width: {{ $percentage }}%">
                                                        {{ $percentage }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- آمار تفصیلی اتاق‌ها -->
        @if(isset($statistics['detailed_room_statistics']) && $statistics['detailed_room_statistics']->count() > 0)
            <div class="row">
                @foreach($statistics['detailed_room_statistics'] as $index => $unit)
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-{{ $this->getColorClass($index) }} text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-door-closed me-2"></i>
                                    {{ $unit['unit_name'] }}
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($unit['rooms']->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="table-light">
                                            <tr>
                                                <th>اتاق</th>
                                                <th>کل</th>
                                                <th>اشغال</th>
                                                <th>رزرو</th>
                                                <th>خالی</th>
                                                <th>وضعیت</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($unit['rooms'] as $room)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $room['room_name'] }}</strong>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">{{ $room['beds']['total'] }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success">{{ $room['beds']['occupied'] }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-warning">{{ $room['beds']['rezerved'] }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $room['beds']['empty'] }}</span>
                                                    </td>
                                                    <td>
                                                        @if($room['beds']['empty'] == $room['beds']['total'])
                                                            <span class="badge bg-info">خالی</span>
                                                        @elseif($room['beds']['occupied'] == $room['beds']['total'])
                                                            <span class="badge bg-danger">کامل</span>
                                                        @else
                                                            <span class="badge bg-warning">نیمه خالی</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>هیچ اتاقی در این واحد تعریف نشده است</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <!-- Custom Styles -->
    <style>
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .badge {
            font-size: 0.9em;
        }
        .progress {
            border-radius: 10px;
        }
        .table th {
            border-top: none;
            font-weight: 600;
        }
        /* فایل resources/css/statistics.css */

        .statistics-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .statistics-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .statistics-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-header-gradient-success {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .card-header-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .card-header-gradient-warning {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
        }
    </style>

        @script
        <script>
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
