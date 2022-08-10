@extends('admin.app')
@section('title', 'Trang quản trị')
@section('main-content')
    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Thống kê đơn hàng
{{--                        <div class="dropdown d-inline">--}}
{{--                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">August</a>--}}
{{--                            <ul class="dropdown-menu dropdown-menu-sm">--}}
{{--                                <li class="dropdown-title">Select Month</li>--}}
{{--                                <li><a href="#" class="dropdown-item">January</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">February</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">March</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">April</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">May</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">June</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">July</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item active">August</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">September</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">October</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">November</a></li>--}}
{{--                                <li><a href="#" class="dropdown-item">December</a></li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $pendingOrderNumber }}</div>
                            <div class="card-stats-item-label">Chờ xử lý</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $successOrderNumber }}</div>
                            <div class="card-stats-item-label">Thành công</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $cancelOrderNumber }}</div>
                            <div class="card-stats-item-label">Hủy</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Tổng số đơn hàng</h4>
                    </div>
                    <div class="card-body">
                        {{ $amountOrder }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Doanh thu</h4>
                    </div>
                    <div class="card-body">
                        {{ number_format($totalMoney, 0 , ',', '.')}} đ
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="sales-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Khách hàng</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalCustomer }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
{{--                <div class="card-header">--}}
{{--                    <h4>Thống kế</h4>--}}
{{--                </div>--}}
                <div class="card-body">
                     <div class="row">
                         <div class="col-6">
                             <div class="form-group">
                                 <label class="form-label">Báo cáo theo</label>
                                 <div class="selectgroup w-100">
{{--                                     <label class="selectgroup-item">--}}
{{--                                         <input onclick="window.location.href='{{ route('dashboard', ['type' => 'day']) }}'" type="radio" name="value" value="50" class="selectgroup-input" @if($typeDate == 'day') checked @endif>--}}
{{--                                         <span class="selectgroup-button">Ngày</span>--}}
{{--                                     </label>--}}
                                     <label class="selectgroup-item">
                                         <input onclick="window.location.href='{{ route('dashboard', ['type' => 'month']) }}'" type="radio" name="value" value="100" class="selectgroup-input" @if($typeDate == 'month') checked @endif>
                                         <span class="selectgroup-button">Tháng</span>
                                     </label>
                                     <label class="selectgroup-item">
                                         <input onclick="window.location.href='{{ route('dashboard', ['type' => 'year']) }}'" type="radio" name="value" value="150" class="selectgroup-input" @if($typeDate == 'year') checked @endif>
                                         <span class="selectgroup-button">Năm</span>
                                     </label>
                                 </div>
                             </div>
                         </div>
                         <div class="col-6">
                             <div class="form-group">
                                 <label for="">Chọn thời gian</label>
                                 <input type="text" class="form-control" name="datepicker" id="datepicker" />
                             </div>
                         </div>
                     </div>
                    <div class="row">
                        <div class="col-12">
                            <div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
@section('links')
    <link rel="stylesheet" href="{{ asset('assets\modules\Date-Time-Picker-Bootstrap-4\build\css\bootstrap-datetimepicker.css')}}">

@section('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('assets\modules\Date-Time-Picker-Bootstrap-4\build\js\bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        const params = new URLSearchParams(window.location.search);

        let formatDate = '';
        if (params.get('type') == 'day') {
            formatDate = 'DD-MM-YYYY';
        } else if (params.get('type') == 'month') {
            formatDate = 'MM-YYYY';
        } else {
            formatDate = 'YYYY';
        }

        $("#datepicker").datetimepicker( {
            format: ''+ formatDate +'',
            defaultDate:new Date()
            // viewMode: "months",
        }).on('dp.change', function(e){
            window.location.href = '{{ route('dashboard', ['type' => $typeDate]) }}&date=' +  e.date.format(formatDate);
        });

        let labels = [];
        @if($typeDate == 'year')
             labels = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7",
                "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];
        @endif

        @if($typeDate == 'month')
            var dt = new Date();
            var month = dt.getMonth() + 1;
            var year = dt.getFullYear();
            let daysInMonth = new Date(year, month, 0).getDate();
            labels =  Array.from(Array(daysInMonth), (_, index) =>  'Ngày ' +(index + 1))
        @endif
        console.log(labels)

        const data = {
            labels: labels,
            datasets: [{
                label: 'Doanh thu',
                data: [
                    @foreach($report as $item)
                    {{ $item }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)'
                ],
                borderWidth: 1
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
@endsection
