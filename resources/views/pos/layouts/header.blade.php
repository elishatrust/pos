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
            <h2 class="text-uppercase">{{ $data['header' ]}}</h2>
            <ul class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="javascript:">App</a></li>
                <li class="breadcrumb-item active">{{ $data['header' ]}}</li>
            </ul>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 justify-content-end">
            <a href="#largeModal" onclick="clear_input()" data-toggle="modal" data-target="#largeModal" title="Add New" class="float-right px-4" style="transform:scale(2.0)"><i class="zmdi zmdi-plus-circle"></i></a>
        </div>
    </div>
</div>

