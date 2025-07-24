{{-- کد Blade تصحیح شده --}}
<div class="resident-management">
    @foreach ($this->allReportService()->getUnitWithDependence() as $data)
        @php
            $colorClass = $this->getColorClass($data['unit']['id']);
        @endphp
        <div class="vahed-card mb-4">
            <div class="card-header vahed-header bg-vahed-{{ $colorClass }}" id="header_vahed_{{ $data['unit']['id'] }}">
                <h4 class="mb-0 text-white">{{ $data['unit']['name'] }}</h4>
            </div>
            <div class="card-body p-0">
                <div class="row g-0">
                    @foreach ($data['rooms'] as $roomData)
                        <div class="col-lg-6 col-xl-6">
                            <div class="otagh-card h-100" id="{{ $roomData['room']['name'] }}">
                                <div class="card-header otagh-header bg--light">
                                    <h5 class="mb-0">{{ $roomData['room']['name'] }}</h5>
                                </div>
                                <div class="card-body p-2">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover modern-table">
                                            <thead class="table-header-{{ $colorClass }}">
                                                <tr>
                                                    <th>تخت</th>
                                                    <th>نام</th>
                                                    <th>تلفن</th>
                                                    <th>سررسید</th>
                                                    <th>مانده تا سررسید</th>
                                                    <th>وضعیت</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roomData['beds'] as $bed)
                                                    @if (!$bed['contracts']->first() || $bed['contracts'] == null)
                                                        <tr class="empty-bed">
                                                            <td class="bed-number">
                                                                {{ substr($bed['bed']['name'], -1) }}
                                                            </td>
                                                            <td colspan="4" class="text-center">
                                                                <span class="empty-bed-text">تخت خالی</span>
                                                            </td>
                                                            <td></td>
                                                            <td class="text-center">
                                                                <button
                                                                    wire:click="openAddModal('{{ $bed['bed']['name'] }}', '{{ $roomData['room']['name'] }}')"
                                                                    class="btn btn-sm btn-outline-success add-resident-btn"
                                                                    title="افزودن ساکن">
                                                                    <i class="fas fa-user-plus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @php
                                                            $contractData = $bed['contracts']->first();
                                                            $contract = $contractData['contract'];
                                                            $resident = $contractData['resident'];
                                                        @endphp
                                                        <tr class="occupied-bed"
                                                            data-resident-id="{{ $resident['id'] }}">

                                                            <td class="bed-number">
                                                                {{ $bed['bed']['name'] }}
                                                            </td>

                                                            <td class="resident-name">
                                                                <input type="text"
                                                                    wire:model="full_name.{{ $resident['id'] }}"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $resident['full_name'] ?? '' }}">
                                                            </td>

                                                            <td class="resident-phone">
                                                                <input type="text"
                                                                    wire:model="phone.{{ $resident['id'] }}"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $resident['phone'] ?? '' }}">
                                                            </td>

                                                            <td class="resident-date">
                                                                <input type="text"
                                                                    wire:model="payment_date.{{ $resident['id'] }}"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $contract['payment_date'] ?? '' }}">
                                                            </td>

                                                            <td class="resident-since">
                                                                {!! $statusService->getStatusBadge($contract['day_since_payment']) !!}
                                                            </td>

                                                            <td class="resident-note">
                                                                @foreach ($contractData['notes'] as $note)
                                                                    <span
                                                                        class="badge rounded-pill text-bg-info p-2">{{ $note['note'] }}</span>
                                                                @endforeach
                                                            </td>

                                                            <td class="action-buttons">
                                                                <a
                                                                    wire:click="editResidentInline({{ $resident['id'] }})"
                                                                    class="btn btn-sm btn-success me-1"
                                                                    title="ذخیره تغییرات">
                                                                    <i class="fa-solid fa-save"></i>
                                                                </a>
                                                                <a
                                                                    wire:click="editResident({{ $resident['id'] }})"
                                                                    class="btn btn-sm btn-primary me-1" title="ویرایش">
                                                                    <i class="fa-solid fa-note-sticky"></i>
                                                                </a>
                                                                <a
                                                                    wire:click="addNoteResident({{ $resident['id'] }})"
                                                                    class="btn btn-sm btn-info me-1"
                                                                    title="اضافه کردن توضیح">
                                                                    <i class="fa-solid fa-pencil"></i>
                                                                </a>


                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

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
