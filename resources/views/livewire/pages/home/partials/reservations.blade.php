<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class='span-rezerve'>رزروها</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="tr-rezerve">
                        <th>#</th>
                        <th>اتاق</th>
                        <th>تخت / کل</th>
                        <th>نام</th>
                        <th>تلفن</th>
                        <th>سررسید</th>
                        <th>مانده</th>
                        <th>توضیحات</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 0;
                    @endphp
                    @foreach ($this->allReportService->getAllResidentsWithDetails() as $data)
                        @if ($data['contract']['state'] == 'rezerve')
                            @php $counter++; @endphp
                            <tr>
                                <td class="text-info">{{ $counter }}</td>
                                <td>{{ $data['room']['name'] }}</td>
                                <td>{{ $data['bed']['name'] }} <i class="fa-solid fa-water"></i>
                                    {{ $data['room']['bed_count'] }}</td>
                                <td>{{ $data['resident']['full_name'] }}</td>
                                <td>{{ $data['resident']['phone'] }}</td>
                                <td>{{ $data['contract']['payment_date'] }}</td>
                                <td>
                                    {!! $statusService->getStatusBadge($data['contract']['day_since_payment']) !!}

                                </td>
                                <td style="max-width: 250px;">
                                    @foreach ($data['notes'] as $note)
                                        <span class="badge rounded-pill text-bg-info p-2">{{ $note['note'] }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('table_list')}}#{{ $data['room']['name'] }}" target="_blank" class="text-primary action-btn">
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
