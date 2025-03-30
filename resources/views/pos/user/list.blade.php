

@extends('pos.layouts.app')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@section('content')

<section class="content contact">
    <div class="container-fluid">

        @include('pos.layouts.header')

        <div class="row clearfix">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="body">

                        <div id="getView">
                            <img src="{{ asset('assets/loader.svg') }}" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">User </h4><strong class="text-danger float-right">Required *</strong>
            </div>
            <div class="modal-body">

                <form id="form" onsubmit="save(event)" enctype="form-data/multipart">
                    @csrf
                    <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" >
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Enter full name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Username <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Phone <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="phone" name="phone" class="form-control" placeholder="Enter phone number" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Enter email" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-8">
                                    <label for="">Password <span class="text-danger">*</span></label>
                                    <div class="form-group" id="show_hide_password">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                                    </div>
                                </div>
                                <div class="col-4 mt-5">
                                    <div class="checkbox" id="show_hide_pwd">
                                        <input id="checkbox" type="checkbox">
                                        <label for="checkbox">Show</label>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger" id="password-option">Note: Enter a password if you want to change it.</span>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Location <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="location" name="location" class="form-control" placeholder="Enter location" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Role <span class="text-danger">*</span></label>
                            <select name="user_role" id="user_role" class="form-control show-tick" required>
                                <option>-- Select --</option>
                                <option value="1">Admin</option>
                                <option value="2">Member</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="user_status" id="user_status" class="form-control show-tick" required>
                                <option>-- Select --</option>
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModel()" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                        <button type="submit" id="submitBtn" class="btn btn-raised btn-primary btn-round waves-effect">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    getView();
    closeModel();
});

$("#show_hide_pwd input").on('click', function (event) {
    event.preventDefault();
    if ($('#show_hide_password input').attr("type") == "text") {
        $('#show_hide_password input').attr('type', 'password');
    } else if ($('#show_hide_password input').attr("type") == "password") {
        $('#show_hide_password input').attr('type', 'text');
    }
});


function getView() {
    jQuery.ajax({
        type: "GET",
        url: "{{ route('admin-user-view') }}",
        dataType: 'html',
        cache: false,
        success: function (data) {
            $("#getView").html(data)
        }
    });
}

function clear_input() {
    document.getElementById('form').reset();
    $("#hidden_id").val("")
    getView()
}

function closeModel(){
    $('#largeModal').modal('hide');
}

function deleteUser(id){
    var conf = confirm("Are you Sure you want to delete this user ?");
    if (!conf) {
        return;
    }

    jQuery.ajax({
        type: "GET",
        url: "/admin/user-delete/"+id,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                showFlashMessage("success", data.message);
                clear_input()
            } else {
                showFlashMessage("warning", data.message);
            }

            disableBtn("submitBtn", false);
            $("#submitBtn").html("Save ")
        }
    });
}

function editUser(id){
    document.getElementById('form').reset();
    $("#hidden_id").val("")

    $("#submitBtn").html("Update");
    $('#largeModal').modal('show');
    $("#password-option").show();

    jQuery.ajax({
        type: "GET",
        url: "/admin/user-edit/"+id,
        dataType: 'json',
        success: function (data) {
            $("#hidden_id").val(data.id)

            var rowData=data.data;

            $("#full_name").val(rowData.name);
            $("#username").val(rowData.username);
            $("#full_name").val(rowData.name);
            $("#phone").val(rowData.phone);
            $("#user_email").val(rowData.email);
            $("#location").val(rowData.location);
            $("#user_role").val(rowData.role);
            $("#user_status").val(rowData.status);
            $("#submitBtn").html("Update");
        }
    });
}

$("#password-option").hide();
function save(e) {
    e.preventDefault();

    $("#submitBtn").html("Update");
    var form = document.getElementById('form');
    var formData = new FormData(form);

    jQuery.ajax({
        type: "POST",
        url: "{{ route('admin-user-save') }}",
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            if (data.status == 200) {
                showFlashMessage("success", data.message);
                clear_input()
            } else {
                showFlashMessage("warning", data.message);
            }

            disableBtn("submitBtn", false);
            $("#submitBtn").html("Save")
        }
    });
}
</script>
@endsection
