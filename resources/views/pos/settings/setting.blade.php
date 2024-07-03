

@extends('pos.layouts.app')
@section('content')

<section class="content contact">
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2 class="text-uppercase">{{ $data['header' ]}}</h2>
                    <ul class="breadcrumb ">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:">App</a></li>
                        <li class="breadcrumb-item active">{{ $data['header' ]}}</li>
                    </ul>
                </div>
            </div>
        </div>
        

        <div class="row clearfix">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong> Business</strong> Settings</h2>
                    </div>
                    <div class="body">
                        <form id="updateSettings">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">
                                <input type="hidden" name="hidden_id" id="hidden_id">
                                <div class="col-lg-12 col-md-12">
                                    <label for="">Name <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" name="business" id="business" class="form-control" placeholder="Business name" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <label for="">Tagline <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" name="tagline" id="tagline" class="form-control" placeholder="Tagline" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <label for="">Mobile <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Mobile phone" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <label for="">Email <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <label for="">Address <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" name="address" id="address" class="form-control" placeholder="Address" required>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <label for="">Website <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" name="website" id="website" class="form-control" placeholder="website" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-round" id="submitBtn">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">

                <div class="card">
                    <div class="header">
                        <h2><strong>Users</strong></h2>
                    </div>
                    <div class="body">
                        <ul class="follow_us list-unstyled m-b-0">
                            @if (!empty($users))
                                @foreach ($users as $user)
                                    <li class="online">
                                        <a href="javascript:">
                                            <div class="media">
                                                <img class="media-object " src="{{ asset('assets/avatar.jpg') }}" alt="">
                                                <div class="media-body">
                                                    <span class="name">{{ $user->name }}</span>
                                                    <span class="message">{{ $user->phone.' | '.Strtoupper($user->warehouse_name) }}</span>
                                                    <span class="badge badge-outline status"></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach                                
                            @else
                                <p>Not Found!</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<script>

$(document).ready(function () {

    getSettingsData();
    
});

function getSettingsData() {
    $.ajax({
        type: "GET",
        url: "{{ route('settings-data') }}",
        dataType: "json",
        success: function(data) {

            var rowData=data.data;

            $("#hidden_id").val(rowData.id);
            $("#business").val(rowData.business);
            $("#tagline").val(rowData.tagline);
            $("#phone").val(rowData.phone);
            $("#email").val(rowData.email);
            $("#address").val(rowData.address);
            $("#website").val(rowData.website);
            $("#submitBtn").html("Update Changes");

        }
    });
}

$('#updateSettings').on('submit', function(e) {
    e.preventDefault();

    var conf = confirm("Are you sure you want to UPDATE settings ?");
    if (!conf) {
        return;
    }
    
    var formData = $(this).serialize();

    var id = $('#hidden_id').val();
    var business = $("#business").val();
    var tagline = $("#tagline").val();
    var phone = $("#phone").val();
    var email = $("#email").val();
    var address = $("#address").val();
    var website = $("#website").val();

    $.ajax({
        url: "{{ url('/update-settings') }}/" + id,
        method: 'PUT',
        data: formData,
        success: function(data) {
            if (data.status == 200) {
                showFlashMessage("success", data.message);
            } else {
                showFlashMessage("warning", data.message);
            }
        }
    });
});
    
</script>


@endsection
