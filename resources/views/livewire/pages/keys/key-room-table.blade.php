<div>
    <div class="container-fluid px-4 py-3" dir="rtl">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-key me-3 fs-4"></i>
                        <h4 class="mb-0 fw-bold">مدیریت کلیدها و اتاق‌ها</h4>
                    </div>
                    <div wire:loading class="spinner-border spinner-border-sm text-white" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light border-bottom">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-6">
                        <label for="search" class="form-label fw-semibold"><i class="fas fa-search me-2"></i>جستجو در
                            کلیدها</label>
                        <input type="text" id="search" wire:model.live.debounce.300ms="search" class="form-control"
                               placeholder="نام، کد یا یادداشت کلید...">
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label for="unitFilter" class="form-label fw-semibold"><i class="fas fa-building me-2"></i>واحد</label>
                        <select id="unitFilter" wire:model.live="selectedUnit" class="form-select">
                            <option value="">همه واحدها</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label for="typeFilter" class="form-label fw-semibold"><i
                                class="fas fa-tags me-2"></i>نوع</label>
                        <select id="typeFilter" wire:model.live="selectedType" class="form-select">
                            <option value="">همه انواع</option>
                            <option value="room">🏠 اتاق</option>
                            <option value="reception">🏢 پذیرش</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                        <tr>
                            <th class="bg-dark text-white" style="width: 150px;">اتاق‌ها \ کلیدها</th>
                            @foreach($keys as $key)
                                <th scope="col" style="cursor: pointer; font-size: 25px"
                                    wire:click="prepareKeyEdit({{ $key->id }})" title="ویرایش کلید {{ $key->name }}">
                                    {{ $key->name }}
                                    <h6 class="d-block text-muted">({{ $key->code }})</h6>
                                </th>
                            @endforeach
                            <th style="width: 50px;">
                                <button wire:click="prepareKeyCreate" class="btn btn-sm btn-success"
                                        title="افزودن کلید جدید">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($keys->isEmpty())
                            <tr>
                                <td colspan="100%" class="text-center py-4">
                                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                                    <p>هیچ کلیدی برای نمایش با فیلترهای فعلی یافت نشد.</p>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td class="fw-bold bg-light">لیست اتاق‌ها</td>
                                @foreach($keys as $key)
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            @forelse($key->rooms as $room)
                                                <span class="badge bg-primary-soft text-primary p-2 flip-3d"
                                                      style="cursor: pointer; font-size: 20px"
                                                      wire:click="prepareAssignmentEdit({{ $key->id }}, {{ $room->id }})"
                                                      title="ویرایش تخصیص">
                                                        <i class="fas fa-door-open me-1"></i> {{ $room->name }}
                                                    </span>
                                            @empty
                                                <span class="text-muted small fst-italic">بدون اتاق</span>
                                            @endforelse
                                            <button class="btn btn-sm btn-outline-primary mt-2"
                                                    wire:click="prepareAssignmentCreate({{ $key->id }})"
                                                    title="تخصیص اتاق جدید">
                                                <i class="fas fa-plus"></i> تخصیص
                                            </button>
                                        </div>
                                    </td>
                                @endforeach
                                <td></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $keys->links() }}
                </div>
            </div>
        </div>
    </div>


    @if($showKeyModal)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="saveKey">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $keyId ? 'ویرایش کلید' : 'افزودن کلید جدید' }}</h5>
                            <button type="button" class="btn-close" wire:click="$set('showKeyModal', false)"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="keyName" class="form-label">نام کلید</label>
                                <input type="text" id="keyName" wire:model.defer="keyName"
                                       class="form-control @error('keyName') is-invalid @enderror">
                                @error('keyName')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="keyCode" class="form-label">کد کلید</label>
                                <input type="text" id="keyCode" wire:model.defer="keyCode"
                                       class="form-control @error('keyCode') is-invalid @enderror">
                                @error('keyCode')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="keyDesc" class="form-label">توضیحات</label>
                                <textarea id="keyDesc" wire:model.defer="keyDesc" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="keyNote" class="form-label">یادداشت</label>
                                <input type="text" id="keyNote" wire:model.defer="keyNote" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer  d-flex justify-content-between">
                            <div>
                                @if($keyId)
                                    <button type="button" class="btn btn-danger" wire:click="confirmRemoveKey">
                                        <span wire:loading.remove wire:target="confirmRemoveKey">حذف کلید</span>
                                        <span wire:loading wire:target="confirmRemoveKey"
                                              class="spinner-border spinner-border-sm"></span>
                                    </button>
                                @endif
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary"
                                        wire:click="$set('showKeyModal', false)">انصراف
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <span wire:loading.remove wire:target="saveKey">ذخیره</span>
                                    <span wire:loading wire:target="saveKey" class="spinner-border spinner-border-sm"
                                          role="status" aria-hidden="true"></span>
                                </button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if($showAssignmentModal)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="saveAssignment">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $isEditingAssignment ? 'ویرایش تخصیص اتاق' : 'تخصیص اتاق جدید به کلید' }}</h5>
                            <button type="button" class="btn-close"
                                    wire:click="$set('showAssignmentModal', false)"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" wire:model="assignmentKeyId">

                            <div class="mb-3">
                                <label for="assignmentRoomId" class="form-label">اتاق</label>
                                @if($isEditingAssignment)
                                    <input type="text" class="form-control"
                                           value="{{ \App\Models\Room::find($assignmentRoomId)->name ?? '' }}" readonly>
                                @else
                                    <select id="assignmentRoomId" wire:model.defer="assignmentRoomId" multiple
                                            class="form-select @error('assignmentRoomId') is-invalid @enderror">
                                        <option value="">یک اتاق را انتخاب کنید...</option>
                                        @forelse($allFilteredRooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @empty
                                            <option value="" disabled>اتاق آزادی برای تخصیص وجود ندارد.</option>
                                        @endforelse
                                    </select>
                                    @error('assignmentRoomId')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="assignmentExpiresAt" class="form-label">تاریخ انقضا (اختیاری)</label>
                                <input type="datetime-local" id="assignmentExpiresAt"
                                       wire:model.defer="assignmentExpiresAt"
                                       class="form-control @error('assignmentExpiresAt') is-invalid @enderror">
                                @error('assignmentExpiresAt')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="assignmentNotes" class="form-label">یادداشت</label>
                                <textarea id="assignmentNotes" wire:model.defer="assignmentNotes"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <div>
                                @if($isEditingAssignment)
                                    <button type="button" class="btn btn-danger" wire:click="removeAssignment"
                                            wire:confirm="آیا از حذف این تخصیص مطمئن هستید؟">
                                        <span wire:loading.remove wire:target="removeAssignment">حذف تخصیص</span>
                                        <span wire:loading wire:target="removeAssignment"
                                              class="spinner-border spinner-border-sm"></span>
                                    </button>
                                @endif
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary"
                                        wire:click="$set('showAssignmentModal', false)">انصراف
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <span wire:loading.remove wire:target="saveAssignment">ذخیره</span>
                                    <span wire:loading wire:target="saveAssignment"
                                          class="spinner-border spinner-border-sm"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Effect 4: 3D Flip */
        .flip-3d {
            background: rgba(255, 255, 255, 0.9);
            /*padding: 20px;*/
            /*margin: 15px 0;*/
            border-radius: 15px;
            transition: all 0.6s ease;
            cursor: pointer;
            transform-style: preserve-3d;
        }

        .flip-3d:hover {
            transform: rotateX(10deg) rotateY(-10deg) translateZ(20px);
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        }

    </style>
</div>
