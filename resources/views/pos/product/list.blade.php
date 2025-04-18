

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
                            <label for="">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control show-tick" required>
                                <option>-- Select --</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Product <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="product" name="product" class="form-control" placeholder="Eg. Phone" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Batch <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="batch" name="batch" class="form-control" placeholder="Eg. July 2023" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Purchase Price <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="purchase_price" name="purchase_price" class="form-control" placeholder="Eg. 4500" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Selling Price <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="selling_price" name="selling_price" class="form-control" placeholder="Eg. 5000" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Discount <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="discount" name="discount" class="form-control" placeholder="Eg. 10" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Stock <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="stock" name="stock" class="form-control" placeholder="Eg. 100" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Status <span class="text-danger">*</span></label>
                            <select name="productStatus" id="productStatus" class="form-control show-tick" required>
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


function getView() {
    jQuery.ajax({
        type: "GET",
        url: "{{ route('admin-product-view') }}",
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
    var conf = confirm("Are you Sure you want to delete this product ?");
    if (!conf) {
        return;
    }

    jQuery.ajax({
        type: "GET",
        url: "/admin/product-delete/"+id,
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
        url: "/admin/product-edit/"+id,
        dataType: 'json',
        success: function (data) {
            $("#hidden_id").val(data.id)

            var rowData=data.data;

            $("#batch").val(rowData.batch);
            $("#product").val(rowData.product);
            $("#purchase_price").val(rowData.purchase_price);
            $("#selling_price").val(rowData.selling_price);
            $("#discount").val(rowData.discount);
            $("#stock").val(rowData.stock);
            $("#category_id").val(rowData.category_id);
            $("#productStatus").val(rowData.status);
            $("#submitBtn").html("Update");
        }
    });
}


function save(e) {
    e.preventDefault();

    $("#submitBtn").html("Save")
    var form = document.getElementById('form');
    var formData = new FormData(form);

    jQuery.ajax({
        type: "POST",
        url: "{{ route('admin-product-save') }}",
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            if (data.status == 200) {
                showFlashMessage("success", data.message);
                clear_input();
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
