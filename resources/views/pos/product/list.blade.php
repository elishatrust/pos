

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
                <h4 class="title" id="largeModalLabel">Product </h4><strong class="text-danger float-right">Required *</strong>
            </div>
            <div class="modal-body">

                <form id="form" onsubmit="save(event)" enctype="form-data/multipart">
                    @csrf
                    <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" >
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="">Batch <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="batch" name="batch" class="form-control" placeholder="Eg. July 2023" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Eg. T-Shirt" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <label for="">Description <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <textarea class="form-control" name="description" id="description" rows="2" placeholder="Eg. Men T-shirt" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="">Cost Price <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="cost" name="cost" class="form-control" placeholder="Eg. 4500TZS" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="">Selling Price <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="selling" name="selling" class="form-control" placeholder="Eg. 5000TZS" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="">Qty (Carton) <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="qty" name="qty" class="form-control" placeholder="Eg. 200" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">MFT Date <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="date" id="mft_date" name="mft_date" class="form-control" placeholder="Eg. 20/12/2010" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Exp Date <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="date" id="exp_date" name="exp_date" class="form-control" placeholder="Eg. 20/12/2025" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="form-control show-tick" required>
                                <option>-- Select --</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Warehouse <span class="text-danger">*</span></label>
                            <select name="warehouse_id" id="warehouse_id" class="form-control show-tick" required>
                                <option>-- Select --</option>
                                @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control show-tick" required>
                                <option>-- Select --</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="u_status" id="u_status" class="form-control show-tick" required>
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

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('mft_date').setAttribute('max', today);
    document.getElementById('exp_date').setAttribute('min', today);

    getView();
    closeModel();


});


function getView() {
    jQuery.ajax({
        type: "GET",
        url: "{{ route('product_view') }}",
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

function deleteProduct(id){
    var conf = confirm("Are you Sure you want to DELETE this Product ?");
    if (!conf) {
        return;
    }

    jQuery.ajax({
        type: "GET",
        url: "/product_delete/"+id,
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

function editProduct(id){
    document.getElementById('form').reset();
    $("#hidden_id").val("")

    $("#submitBtn").html("Update");
    $('#largeModal').modal('show');

    jQuery.ajax({
        type: "GET",
        url: "/product_edit/"+id,
        dataType: 'json',
        success: function (data) {
            $("#hidden_id").val(data.id)

            var rowData=data.data;

            $("#batch").val(rowData.batch);
            $("#product_name").val(rowData.name);
            $("#description").val(rowData.description);
            $("#cost").val(rowData.cost);
            $("#selling").val(rowData.selling);
            $("#qty").val(rowData.qty);
            $("#mft_date").val(rowData.mft_date);
            $("#exp_date").val(rowData.exp_date);
            $("#supplier_id").val(rowData.supplier_id);
            $("#warehouse_id").val(rowData.warehouse_id);
            $("#category_id").val(rowData.category_id);
            $("#u_status").val(rowData.status);
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
        url: "{{ route('product_save') }}",
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
