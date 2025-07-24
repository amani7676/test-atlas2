<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>فرم‌ها</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اتاق</th>
                        <th>نام</th>
                        <th>تلفن</th>
                        <th>سررسید</th>
                        <th>توضیح</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 0;
                    @endphp
                    @foreach ($this->allReportService->getAllResidentsWithDetails() as $data)
                       @if (!$data['resident']['form'])
                            @php
                                $counter++;
                            @endphp
                            <tr>
                                <td class="text-info">{{ $counter }}</td>
                                <td>{{ $data['room']['name'] }}</td>
                                <td>{{ $data['resident']['full_name'] }}</td>
                                <td>{{ $data['resident']['phone'] }}</td>
                                <td>{{ $data['contract']['payment_date'] }}</td>
                                <td style="max-width: 250px;">
                                    @foreach ($data['notes'] as $note)
                                        @if ($note['type'] === 'payment')
                                            <span class="badge rounded-pill text-bg-info p-2">{{ $note['note'] }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a href="#" wire:click.prevent="giveForm({{ $data['resident']['id'] }})"
                                        class="text-success action-btn">
                                        <i class="fas fa-check-circle"></i>
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
