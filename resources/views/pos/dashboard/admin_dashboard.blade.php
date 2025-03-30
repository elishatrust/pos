@extends('pos.layouts.app')
@section('content')

<section class="content home">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 d-flex justify-content-between">
                                <h4 class="margin-0 text-uppercase text-danger">{{ $data['title']}}</h4>
                                <span id="clock">
                                    @php
                                        date_default_timezone_set('UTC');
                                        echo date('H:i:s')                                
                                    @endphp
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Dashboard</h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item active">{{ $data['header'] }}</li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div class="input-group m-b-0">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-search"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{ route('admin-user') }}">
                        <div class="card text-center">
                            <div class="body">
                                <p class="m-b-20"><i class="zmdi zmdi-account-box zmdi-hc-3x col-green"></i></p>
                                <span>TOTAL USER</span>
                                <h3 class="m-b-0 number count-to" data-from="0" data-to="{{ !empty($user) ? $user : 0 }}" data-speed="2000" data-fresh-interval="700">{{ !empty($user) ? $user : 0 }}</h3>
                                <small class="text-muted">{{ (($user - $inactiveUser)/$user) *100 }}% Active User</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{ route('admin-product') }}">
                        <div class="card text-center">
                            <div class="body">
                                <p class="m-b-20"><i class="zmdi zmdi-balance zmdi-hc-3x col-amber"></i></p>
                                <span>TOTAL PRODUCT</span>
                                <h3 class="m-b-0 number count-to" data-from="0" data-to="{{  !empty($product) ? $product : 0 }}" data-speed="2000" data-fresh-interval="700">{{  !empty($product) ? $product : 0 }}</h3>
                                {{-- <small class="text-muted">27% lower growth</small> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{ route('admin-sales') }}">
                        <div class="card text-center">
                            <div class="body">
                                <p class="m-b-20"><i class="zmdi zmdi-assignment zmdi-hc-3x col-blue"></i></p>
                                <span>TOTAL SALES</span>
                                <h3 class="m-b-0 number count-to" data-from="0" data-to="0" data-speed="2000" data-fresh-interval="700">0</h3>
                                {{-- <h3 class="m-b-0 number count-to" data-from="0" data-to="{{  !empty($sales) ? $sales : 0 }}" data-speed="2000" data-fresh-interval="700">{{  !empty($sales) ? $sales : 0 }}</h3> --}}
                                {{-- <small class="text-muted">88% lower growth</small> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{ route('admin-category') }}">
                        <div class="card text-center">
                            <div class="body">
                                <p class="m-b-20"><i class="zmdi zmdi-shopping-basket zmdi-hc-3x"></i></p>
                                <span>TOTAL CATEGORIES</span>
                                <h3 class="m-b-0 number count-to" data-from="0" data-to="{{ !empty($category) ? $category : 0 }}" data-speed="2000" data-fresh-interval="700">{{ !empty($category) ? $category : 0 }}</h3>
                                {{-- <small class="text-muted">38% lower growth</small> --}}
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <hr>

        </div>

        <div class="row clearfix">
            <div class="col-lg-8 col-md-6 com-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Application</strong> Sales <small>Members Preformance / Monthly Status</small> </h2>
                        <ul class="header-dropdown">
                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                    <li><a href="javascript:void(0);" class="boxs-close">Deletee</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body sales_report">
                        <div class="table-responsive">
                            <table class="table m-b-0 table-hover">
                                <thead>
                                    <tr>
                                        <th>Application</th>
                                        <th>Team</th>
                                        <th>Change</th>
                                        <th>Sales</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h6>Alpino 4.1</h6>
                                            <span>WrapTheme To By Again</span>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled team-info">
                                                <li><img src="assets/images/xs/avatar1.jpg" alt="Avatar"></li>
                                                <li><img src="assets/images/xs/avatar2.jpg" alt="Avatar"></li>
                                                <li><img src="assets/images/xs/avatar3.jpg" alt="Avatar"></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1.5" data-line-Color="#00c5dc"
                                            data-fill-Color="transparent">3,5,1,6,5,4,8,3</div>
                                        </td>
                                        <td>11,200</td>
                                        <td>$83</td>
                                        <td><strong>$22,520</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6>Compass 2.0</h6>
                                            <span>WrapTheme To By Again</span>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled team-info">
                                                <li><img src="assets/images/xs/avatar2.jpg" alt="Avatar"></li>
                                                <li><img src="assets/images/xs/avatar3.jpg" alt="Avatar"></li>
                                                <li><img src="assets/images/xs/avatar4.jpg" alt="Avatar"></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1.5" data-line-Color="#f4516c"
                                            data-fill-Color="transparent">4,6,3,2,5,6,5,4</div>
                                        </td>
                                        <td>11,200</td>
                                        <td>$66</td>
                                        <td><strong>$13,205</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6>Nexa 1.1</h6>
                                            <span>WrapTheme To By Again</span>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled team-info">
                                                <li><img src="assets/images/xs/avatar4.jpg" alt="Avatar"></li>
                                                <li><img src="assets/images/xs/avatar6.jpg" alt="Avatar"></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1.5" data-line-Color="#31db3d"
                                            data-fill-Color="transparent">7,3,2,1,5,4,6,8</div>
                                        </td>
                                        <td>12,080</td>
                                        <td>$93</td>
                                        <td><strong>$17,700</strong></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h6>Oreo 2.2</h6>
                                            <span>ThemeMakker To By Again</span>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled team-info">
                                                <li><img src="assets/images/xs/avatar1.jpg" alt="Avatar"></li>
                                                <li><img src="assets/images/xs/avatar3.jpg" alt="Avatar"></li>
                                                <li><img src="assets/images/xs/avatar2.jpg" alt="Avatar"></li>
                                                <li><img src="assets/images/xs/avatar9.jpg" alt="Avatar"></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="sparkline text-left" data-type="line" data-width="8em" data-height="20px" data-line-Width="1.5" data-line-Color="#2d342e"
                                            data-fill-Color="transparent">3,1,2,5,4,6,2,3</div>
                                        </td>
                                        <td>18,200</td>
                                        <td>$178</td>
                                        <td><strong>$17,700</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Performance</strong> Statistics </h2>
                    </div>
                    <div class="body align-center">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="margin-0">60%</h4>
                                <p>Monthly</p>
                            </div>
                            <div class="col-4">
                                <h4 class="margin-0">20%</h4>
                                <p>Weekly</p>
                            </div>
                            <div class="col-4">
                                <h4 class="margin-0">30%</h4>
                                <p>Daily</p>
                            </div>
                        </div>
                        <div class="sparkline-pie">6,1,3</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
