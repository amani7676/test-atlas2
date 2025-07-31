<div>
    <style>
        body {
            background: linear-gradient(135deg, #0118D8 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .container-fluid {
            max-width: 1400px;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-left: 5px;
        }

        .table-title {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .table {
            margin-bottom: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px 12px;
            text-align: center;
            font-size: 0.95rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            cursor: pointer;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table tbody tr.occupied {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .table tbody tr.editing {
            background-color: rgba(102, 126, 234, 0.1);
            border: 2px solid #667eea;
        }

        .table tbody td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
            border: none;
            font-size: 0.9rem;
        }

        .room-number {
            font-weight: bold;
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
            padding: 8px 12px;
            border-radius: 8px;
            display: inline-block;
        }

        .room-number.occupied {
            background: #90C67C;
            color: #0118D8;
        }

        .phone-input, .date-input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 8px 12px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .phone-input:focus, .date-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .main-title {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .table tbody tr:nth-child(even) {
            background-color: rgba(248, 249, 250, 0.5);
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 0.8rem;
        }

        .alert {
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px 15px 0 0;
        }

        @media (max-width: 768px) {
            .main-title {
                font-size: 2rem;
            }

            .table-container {
                padding: 15px;
                margin-bottom: 10px;
            }

            .table thead th,
            .table tbody td {
                padding: 8px 6px;
                font-size: 0.8rem;
            }

            .phone-input, .date-input {
                padding: 6px 8px;
                font-size: 0.8rem;
            }
        }
    </style>

    <div class=" mt-4" dir="rtl">
        <div class="row g-3">
            @foreach($rooms as $floor => $floorRooms)
                <div class="col-lg-3 col-md-3">
                    <div class="table-container">
                        <div class="table-title">
                            <i class="fas fa-door-open"></i>
                            اتاق‌های {{ $floor }}01
                            - {{ $floor }}{{ str_pad($floorRooms->count(), 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>شماره اتاق</th>
                                    <th>نام</th>
                                    <th>سررسید</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($floorRooms as $room)
                                    @foreach($room->beds as $bed)
                                        @php
                                            $bedInfo = $this->getBedInfo($bed);

                                        @endphp
                                        <tr class="{{ $bedInfo['occupied'] ? '' : 'bg-danger-light' }} ">
                                            <td>
                                                    <span
                                                        class="room-number {{ $bedInfo['occupied'] ? 'occupied' : '' }}">
                                                        {{ $room->name }}
                                                    </span>
                                            </td>
                                            <td>

                                                    {{ $bedInfo['name'] ?: 'خالی' }}
                                            </td>
                                            <td>
                                                    {{ $bedInfo['date'] ?: '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="position-fixed top-50 start-50 translate-middle">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">در حال بارگذاری...</span>
        </div>
    </div>
</div>

