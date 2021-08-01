@include ('backend.layouts.header')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ breadcrumb ] start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="page-header-title">
                                            <h5>Home</h5>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="#!">Analytics Dashboard</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ breadcrumb ] end -->
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!-- product profit start -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card bg-c-blue">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-25">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Vendors</h6>
                                                <h3 class="m-b-0 text-white">{{$total_vendors}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-store-alt text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card bg-c-green">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-25">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Active Vendors</h6>
                                                <h3 class="m-b-0 text-white">{{$total_active_vendors}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-store-alt text-c-green f-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card bg-c-red">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-25">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Disabled Vendors</h6>
                                                <h3 class="m-b-0 text-white">{{$total_disabled_vendors}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-store-alt text-c-red f-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card bg-c-yellow">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-25">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Total Invoices</h6>
                                                <h3 class="m-b-0 text-white">{{$total_invoices}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-file-invoice text-c-yellow f-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card bg-c-blue">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-25">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Total Users</h6>
                                                <h3 class="m-b-0 text-white">{{$total_users}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-database text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card bg-c-green">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-25">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Users Verified</h6>
                                                <h3 class="m-b-0 text-white">{{$total_users}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-database text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card bg-c-red">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-25">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Users Not Verified</h6>
                                                <h3 class="m-b-0 text-white">{{$total_users}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-database text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card bg-c-yellow">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-25">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Total QR Scan</h6>
                                                <h3 class="m-b-0 text-white">1500</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-qrcode text-c-yellow f-18"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>QR Scan Analytics</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="morris-bar-chart" style="height:300px"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ bar-simple Chart ] end -->
                            <div class="col-md-6 col-xl-4">
                                <div class="card user-card">
                                    <div class="card-header">
                                        <h5>Invoice Analytics</h5>
                                    </div>
                                    <div class="card-body  text-center">
                                        <div class="card-body px-0 py-0">
                                            <div id="morris-donut-chart"></div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@include ('backend.layouts.footer')
<script>
    $(document).ready(function() {
        setTimeout(function () {
            Morris.Donut({
                element: 'morris-donut-chart',
                data: [{
                    value: 25,
                    label: 'Data 1'
                },
                    {
                        value: 20,
                        label: 'Data 1'
                    },
                    {
                        value: 10,
                        label: 'Data 1'
                    },
                    {
                        value: 5,
                        label: 'Data 1'
                    }
                ],
                colors: [
                    '#3949AB',
                    '#463699',
                    '#e52d27',
                    '#f57c00',
                ],
                resize: true,
                formatter: function (x) {
                    return "val : " + x
                }
            });
            // [ line-angle-chart ] Start
            Morris.Bar({
                element: 'morris-bar-chart',
                data: [{
                    y: 'Daily',
                    a: 50,
                    b: 40,
                    c: 35,
                },
                    {
                        y: 'weekly',
                        a: 75,
                        b: 65,
                        c: 60,
                    },
                    {
                        y: 'Monthly',
                        a: 50,
                        b: 40,
                        c: 55,
                    },
                    {
                        y: 'Yearly',
                        a: 75,
                        b: 65,
                        c: 85,
                    },
                ],
                xkey: 'y',
                barSizeRatio: 0.70,
                barGap: 3,
                resize: true,
                responsive: true,
                ykeys: ['a', 'b', 'c'],
                labels: ['Bar 1', 'Bar 2', 'Bar 3'],
                barColors: ["#3949AB", "#463699", "#2ca961"]
            });
            // [ line-angle-chart ] end
        }, 700);
    });
</script>
