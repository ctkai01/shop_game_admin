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
            margin-top: 50px
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
                            <div><span>Wallet Balance</span>
                                <h3 class="font-medium m-b-0">$3,567.53</h3>
                            </div>
                        </div>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10"><span class="text-cyan display-5"><i class="mdi mdi-star-circle"></i></span></div>
                            <div><span>Referral Earnings</span>
                                <h3 class="font-medium m-b-0">$769.08</h3>
                            </div>
                        </div>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10"><span class="text-info display-5"><i class="mdi mdi-shopping"></i></span></div>
                            <div><span>Estimate Sales</span>
                                <h3 class="font-medium m-b-0">5489</h3></div>
                        </div>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="m-r-10"><span class="text-primary display-5"><i class="mdi mdi-currency-usd"></i></span></div>
                            <div><span>Earnings</span>
                                <h3 class="font-medium m-b-0">$23,568.90</h3>
                            </div>
                        </div>
                    </div>
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

            
        })
    </script>
@endpush
