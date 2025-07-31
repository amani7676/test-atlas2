<div>
    <div class="container-fluid mt-3" style="width: 90%">


        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-primary">
                        <i class="fas fa-bed me-2"></i>
                        رزروها
                    </h2>
                    <button wire:click="showCreateForm" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>
                        رزرو جدید
                    </button>
                </div>
            </div>
        </div>

        {{-- Form Section --}}
        @if($showForm)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-{{ $editingId ? 'edit' : 'plus' }} me-2"></i>
                            {{ $editingId ? 'ویرایش رزرو' : 'رزرو جدید' }}
                        </h5>
                        <button wire:click="hideForm" class="btn btn-sm btn-outline-light">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            {{-- Personal Information --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">نام و نام خانوادگی</label>
                                    <input type="text"
                                           wire:model="full_name"
                                           class="form-control @error('full_name') is-invalid @enderror"
                                           placeholder="نام کامل را وارد کنید">
                                    @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">شماره تماس</label>
                                    <input type="text"
                                           wire:model="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           placeholder="09xxxxxxxxx">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">اولویت</label>
                                    <select wire:model="priority"
                                            class="form-select @error('priority') is-invalid @enderror">
                                        <option value="low">کم</option>
                                        <option value="medium">متوسط</option>
                                        <option value="high">بالا</option>
                                    </select>
                                    @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Bed Details --}}
                            @if($bedDetails)
                                <div class="col-12">
                                    <div class="card bg-light mb-3">
                                        <div class="card-header">
                                            <h6 class="mb-0">جزئیات تخت انتخابی</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>اتاق:</strong> {{ $bedDetails->room->name ?? 'نامشخص' }}
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>شماره تخت:</strong> {{ $bedDetails->name }}
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>وضعیت:</strong>
                                                    @if($bedDetails->resident)
                                                        <span class="badge bg-danger">اشغال</span>
                                                    @else
                                                        <span class="badge bg-success">خالی</span>
                                                    @endif
                                                </div>
                                                @if($bedDetails->resident)
                                                    <div class="col-md-3">
                                                        <strong>ساکن فعلی:</strong> {{ $bedDetails->resident->full_name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Note --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">یادداشت</label>
                                    <textarea wire:model="note"
                                              class="form-control @error('note') is-invalid @enderror"
                                              rows="3"
                                              placeholder="یادداشت اختیاری..."></textarea>
                                    @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                {{ $editingId ? 'ویرایش' : 'ذخیره' }}
                            </button>
                            <button type="button" wire:click="hideForm" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                انصراف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Filters Section --}}
{{--        <div class="card mb-4">--}}
{{--            <div class="card-body">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label">جستجو</label>--}}
{{--                            <input type="text"--}}
{{--                                   wire:model.live="search"--}}
{{--                                   class="form-control"--}}
{{--                                   placeholder="جستجو در نام یا شماره تماس...">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label class="form-label">فیلتر بر اساس اولویت</label>--}}
{{--                            <select wire:model.live="filterPriority" class="form-select">--}}
{{--                                <option value="">همه اولویت‌ها</option>--}}
{{--                                <option value="high">بالا</option>--}}
{{--                                <option value="medium">متوسط</option>--}}
{{--                                <option value="low">کم</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        {{-- Reserves List --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    لیست رزروها ({{ count($reserves) }} مورد)
                </h5>
            </div>
            <div class="card-body p-0">
                @if(count($reserves) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th style="width: 15%">نام و نام خانوادگی</th>
                                <th style="width: 15%">شماره تماس</th>
                                <th style="width: 5%">اولویت</th>
                                <th style="width: 35%">یادداشت</th>

                                <th style="width: 15%">تاریخ ایجاد</th>
                                <th width="150">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reserves as $reserve)
                                <tr>
                                    <td>
                                        <strong>{{ $reserve->full_name }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $reserve->phone }}</span>
                                    </td>

                                    <td>
                                        <span class="{{ $this->getPriorityClass($reserve->priority) }}">
                                            {{ $this->getPriorityLabel($reserve->priority) }}
                                        </span>
                                    </td>
                                    <td >
                                        @if($reserve->note)
                                            <span class="text-muted"
                                                  title="{{ $reserve->note }}"
                                                  data-bs-toggle="tooltip">
                                                {{ $reserve->note}}
                                            </span>
                                        @else
                                            <span class="text-muted fst-italic">بدون یادداشت</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $reserve->created_at->format('Y/m/d H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button wire:click="edit({{ $reserve->id }})"
                                                    class="btn btn-outline-primary"
                                                    title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="delete({{ $reserve->id }})"
                                                    class="btn btn-outline-danger"
                                                    title="حذف"
                                                    onclick="return confirm('آیا از حذف این رزرو اطمینان دارید؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">هیچ رزروی یافت نشد</h5>
                        <p class="text-muted">برای شروع، یک رزرو جدید ایجاد کنید.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>

            .required::after {
                content: " *";
                color: red;
            }

            .table th {
                border-top: none;
                font-weight: 600;
                color: #495057;
            }

            .btn-group-sm > .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }

            .card {
                border: none;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid #e9ecef;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });

            // گوش دادن به رویداد 'show-toast'
            window.addEventListener('show-toast', (event) => {
                const params = event.detail[0];

                if (typeof window.cuteToast === 'function') {
                    cuteToast({
                        type: params.type,
                        title: params.title,
                        description: params.description,
                        timer: params.timer
                    });
                } else {
                    console.error('cuteToast function is not available on window object.');
                }
            });

        </script>
    @endpush
</div>
