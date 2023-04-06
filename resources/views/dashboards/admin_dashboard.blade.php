@extends('layouts.master')
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">App Users</p>
                                    <h4 class="mb-0">{{ number_format($data['user'])}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-download font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Active Users</p>
                                    <h4 class="mb-0">{{ number_format($data['active_user'])}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-user font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Inactive Users</p>
                                    <h4 class="mb-0">{{ number_format($data['inactive_user'])}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-danger mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-danger">
                                            <i class="bx bx-user font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Average Income</p>
                                    <h4 class="mb-0">{{ number_format($data['average_income'])}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- end row -->

                   
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Monthly Summary of Total Users , No of Transactions vs No of Budgets</h4>
                            
                            <div id="column_chart"  data-colors='["#FA0824","#556EE5", "#34C38F"]' class="apex-charts" dir="ltr"></div>                                      
                        </div>
                    </div><!--end card-->
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Expenses Chart</h4>
                            
                            <div id="bar_chart" data-colors='["#FA0824"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div><!--end card-->
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Latest Transaction</h4>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">#</th>
                                            <th class="align-middle">Date</th>
                                            <th class="align-middle">User</th>
                                            <th class="align-middle">Amount</th>
                                            <th class="align-middle">Category</th>
                                            <th class="align-middle">Account</th>
                                            <th class="align-middle">Txn Type</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                    @foreach ($ledgers as $ledger)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d ,M-Y H:i:s',strtotime($ledger->created_at))}}</td>
                                            <td>{{ $ledger->user->name ?? null.' '.$ledger->user->last_name ?? null  }}</td>
                                            <td>{{ number_format($ledger->amount) }}</td>
                                            <td>{{ $ledger->category->name_en ?? null}}</td>
                                            <td>{{ $ledger->account->name ?? null}}</td>
                                            <td>{{ $ledger->txn_type }}</td>
                                        </tr>
                                    
                                     @endforeach
                                   </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    
@endsection
@push('scripts')
    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- apexcharts init -->
    {{-- <script src="{{ asset('assets/js/pages/apexcharts.init.js')}}"></script> --}}
    <script>
        $(document).ready(function(){
            
            var promise=  ajaxCall().done(function(response) {
                columnChartjs(response.users,response.transactions,response.budgets); 
            }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(errorThrown);
            });
        })
    </script>
    <script>
        function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            var t = document.getElementById(e).getAttribute("data-colors");
            if (t) return (t = JSON.parse(t)).map(function(e) {
                var t = e.replace(" ", "");
                if (-1 === t.indexOf(",")) {
                    var r = getComputedStyle(document.documentElement).getPropertyValue(t);
                    return r || t
                }
                var o = e.split(",");
                return 2 != o.length ? t : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(o[0]) + "," + o[1] + ")"
            });
            console.warn("data-colors Attribute not found on:", e)
        }
        }

        function columnChartjs(users,transactions,budgets){
            var user =JSON.parse(users);
            var transaction =JSON.parse(transactions);
            var budget      =JSON.parse(budgets);
            var columnChartColors = getChartColorsArray("column_chart");
            columnChartColors && (options = {
            chart: {
                height: 350,
                type: "bar",
                toolbar: {
                    show: !1
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "45%",
                    endingShape: "rounded"
                }
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                show: !0,
                width: 2,
                colors: ["transparent"]
            },
            series: [{
                name: "No of Users",
                data: user,
            }, {
                name: "No of Transactions",
                data: transaction,
            }, {
                name: "No of Budgets",
                data: budget
            }],
            colors: columnChartColors,
            xaxis: {
                categories: ["Jan","Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"]
            },
            yaxis: {
                title: {
                    text: "Monthly Summary",
                    style: {
                        fontWeight: "500"
                    }
                }
            },
            grid: {
                borderColor: "#f1f1f1"
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(e) {
                        return "" + e + ""
                    }
                }
            }
        }, (chart = new ApexCharts(document.querySelector("#column_chart"), options)).render());
        }
    

var barChartColors = getChartColorsArray("bar_chart");
barChartColors && (options = {
    chart: {
        height: 350,
        type: "bar",
        toolbar: {
            show: !1
        }
    },
    plotOptions: {
        bar: {
            horizontal: !0
        }
    },
    dataLabels: {
        enabled: !1
    },
    series: [{
        data: [380, 430, 450, 475, 550, 584, 780, 1100]
    }],
    colors: barChartColors,
    grid: {
        borderColor: "#f1f1f1"
    },
    xaxis: {
        categories: ["Groceries", "Personal Care", "Food & Beverages", "Health", "Education", "Help & Giving", "Projects", "Others"]
    }
}, (chart = new ApexCharts(document.querySelector("#bar_chart"), options)).render());

    function ajaxCall() {
        return $.ajax({
            type:'GET',
            url:" {{ route('admin.column.chart') }}",
            contentType: false,
            cache: false,
            processData : false,
            success:function(response){
                // Handle the response inside the success function if needed
            },
            error:function(response){
                console.log(response.responseText);
            },
            beforeSend : function(){
               
            },
            complete : function(){
              }
        }); 
    }
    </script>
@endpush