

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



<div class="modal" id="largeModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Sales </h4><strong class="text-danger float-right">Required *</strong>
            </div>
            <div class="modal-body">
                <form id="form" onsubmit="save(event)" enctype="form-data/multipart">
                    @csrf
                    <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" >

                    <div class="row" id="searchForm">
                        <div class="col-md-12 col-sm-12">
                            <label for="">Customer <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id" class="form-control show-tick" required>
                                <option>~Select~</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name ." - " . $customer->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="">Items <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="total_item" name="total_item" class="form-control" placeholder="Total items" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="">Price <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="total_price" name="total_price" class="form-control" placeholder="Total price" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="">Discount <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="discount" name="discount" class="form-control" placeholder="Total discount" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Accept <span class="text-danger">*</span></label>
                            <select name="accept" id="accept" class="form-control show-tick" required>
                                <option>~Select~</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="showStatus" id="showStatus" class="form-control show-tick" required>
                                <option>~Select~</option>
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


function getView() {
    jQuery.ajax({
        type: "GET",
        url: "{{ route('admin-sales-view') }}",
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

function deleteSales(id){
    var conf = confirm("Are you Sure you want to delete ?");
    if (!conf) {
        return;
    }

    jQuery.ajax({
        type: "GET",
        url: "/admin-sales-delete/"+id,
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

function editSales(id){
    document.getElementById('form').reset();
    $("#hidden_id").val("")

    $("#submitBtn").html("Update");
    $('#largeModal').modal('show');

    jQuery.ajax({
        type: "GET",
        url: "/admin/sales-edit/"+id,
        dataType: 'json',
        success: function (data) {
            $("#hidden_id").val(data.id)

            var rowData=data.data;

            $("#customer_id").val(rowData.user_id);
            $("#total_item").val(rowData.total_item);
            $("#total_price").val(rowData.total_price);
            $("#discount").val(rowData.discount);
            $("#accept").val(rowData.accept);
            $("#showStatus").val(rowData.status);
            $("#submitBtn").html("Update");
        }
    });
}


function save(e) {
    e.preventDefault();

    var form = document.getElementById('form');
    var formData = new FormData(form);

    jQuery.ajax({
        type: "POST",
        url: "{{ route('admin-sales-save') }}",
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
