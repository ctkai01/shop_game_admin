@extends('layouts.app')
@section('title_for_layout', 'Dashboard')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #myChart , .ct-charts {
            width: 100% !important;
            height: 100% !important;
        }

        html {
            font-size: 14px
        }

        .card-body {
            padding: 0 !important;
        }
        .page-wrapper>.container-fluid {
            min-height: 100vh;
            padding: 20px 40px;
        }

        .statis-box {
            margin-top: 50px;
            /* display: flex;
            justify-content: center; */
        }

        .align-items-center {
            padding-left: 20px
        }

        .custom-select {
            background: red;
            border: none;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 10px;
        }
        .chart-section {
            padding: 25px 30px 10px !important;
        }
        
    </style>
@endsection
@section('bread')
{{ Breadcrumbs::render('dashboard') }}
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body chart-section">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Sales Summary</h4>
                        <h5 class="card-subtitle">Overview of Latest Week</h5>
                    </div>
                    <div class="ml-auto d-flex no-block align-items-center">
                        <div class="dl">
                            <select class="custom-select">
                                <option value="0" selected>Weekly</option>
                                <option value="1">Monthly</option>
                                <option value="2">Yearly</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 500px">
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-12 ct-charts">
                        <div class="campaign ct-charts">
                            <canvas style="width: 100%; height: 100%" id="myChart"></canvas>
                        </div>
                    </div>
                    <!-- column -->
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Info Box -->
            <!-- ============================================================== -->
            <div class="card-body statis-box border-top">
                <div class="row m-b-0">
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10"><span class="text-orange display-5"><i class="mdi mdi-wallet"></i></span></div>
                            <div><span>Total Amount Recharged</span>
                                <h3 class="font-medium m-b-0 totalRecharge">{{ $totalRecharge }}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10"><span class="text-cyan display-5"><i class="mdi mdi-star-circle"></i></span></div>
                            <div><span>Total Amount bought</span>
                                <h3 class="font-medium m-b-0 totalBought">{{ $totalBought }}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    {{-- <div class="col-lg-3 col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10"><span class="text-info display-5"><i class="mdi mdi-shopping"></i></span></div>
                            <div><span>Estimate Sales</span>
                                <h3 class="font-medium m-b-0">5489</h3></div>
                        </div>
                    </div> --}}
                    <!-- col -->
                    <!-- col -->
                    {{-- <div class="col-lg-3 col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10"><span class="text-primary display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                            <div><span>Earnings</span>
                                <h3 class="font-medium m-b-0">$23,568.90</h3>
                            </div>
                        </div>
                    </div> --}}
                    <!-- col -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js" crossorigin="anonymous"></script>
        
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // const formatToCurrency = (amount) => {
            //     return "$" + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
            // };
            const totalRecharge = parseInt($(".totalRecharge").text()) 
            const totalBought = parseInt($(".totalBought").text()) 
            $(".totalRecharge").text(totalRecharge.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") + " VNĐ")
            $(".totalBought").text(totalBought.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,") + " VNĐ")
           
            let myChart = document.getElementById('myChart').getContext('2d');

            var massPopChart = new Chart(myChart, {
                type:'bar', 
                data:{
                    labels: [],
                    datasets:[{
                        label:'Product',
                        data: [],
                        backgroundColor:'rgb(0,191,255)',
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }]
                },
                options:{
                    title:{
                        display:true,
                        fontSize:25
                    },
                    legend:{
                        display:true,
                        position:'right',
                        labels:{
                            fontColor:'#000',
                            fontSize: '50px'
                        }
                    },
                    layout:{
                        padding:{
                            left:50,
                            right:0,
                            bottom:0,
                            top:0
                        }
                    },
                    tooltips:{
                        enabled: true
                    }
                }
            });
            function addData(chart, label, data) {
                chart.data.labels = label;
                chart.data.datasets[0].data = data
                chart.update();
            }

            const statisticalUser = function() {
                $.ajax({
                    url: "{{ route('dashboard.product') }}",
                    type: 'POST',
                    data: {
                        time: $('.custom-select option:selected').attr('value'),
                    },
                    success: function(data) {
                        console.log(data)
                        if ( data.type === 'Week' ) {
                            labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
                            $('.card-subtitle').text('Overview of Latest Week')
                            addData(massPopChart, labels, data.users)

                        } else if ( data.type === 'Month' ) {
                            var dt = new Date();
                            var month = dt.getMonth() + 1;
                            var year = dt.getFullYear();
                            var daysInMonth = new Date(year, month, 0).getDate();
                            labels = []
                            for ( i = 1; i <= daysInMonth; i++ ) {
                                labels.push(i)
                            }
                            $('.card-subtitle').text('Overview of Latest Month')
                            addData(massPopChart, labels, data.users)

                        } else if ( data.type === 'Year' ) {
                            labels = ['January', 'February', 'March', 'April', 
                                    'May', 'June', 'July', 'August', 'September', 
                                    'October', 'November', 'December'
                                    ]
                            $('.card-subtitle').text('Overview of Latest Year')
                            addData(massPopChart, labels, data.users)
                        }
                    },
                    erro: function(error) {
                        console.log('err')
                    }
                })
            }

            statisticalUser()

            $( ".custom-select" ).change(function() {
                statisticalUser() 

            });
        })
    </script>
@endpush
