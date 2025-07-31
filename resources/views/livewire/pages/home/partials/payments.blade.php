<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>بدهی‌ها</span>
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

                @php $counter = 1; @endphp

                @foreach ($this->allReportService->getAllResidentsWithDetails() as $data)
                    @if ($data['notes']->contains(fn($note) => in_array($note['type'], ['payment'])))
                        <tr>
                            <td class="text-info">{{ $counter++ }}</td>
                            <td>{{ $data['room']['name'] }}</td>
                            <td>{{ $data['resident']['full_name'] }}</td>
                            <td>{{ $data['resident']['phone'] }}</td>
                            <td>{{ $data['contract']['payment_date'] }}</td>
                            <td style="max-width: 250px;">
                                @foreach ($data['notes'] as $note)
                                    <span class="badge rounded-pill text-dark p-2">
                        {{ $this->noteRepository->formatNoteForDisplay($note) }}
                    </span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('table_list') }}#{{ $data['room']['name'] }}" target="_blank"
                                   class="text-primary action-btn">
                                    <i class="fas fa-external-link-alt"></i>
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
