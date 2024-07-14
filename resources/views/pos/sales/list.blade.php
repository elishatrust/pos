

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
                <h4 class="title" id="largeModalLabel">Sale Order </h4><strong class="text-danger float-right">Required *</strong>
            </div>
            <div class="modal-body">
                <form id="form" onsubmit="save(event)" enctype="form-data/multipart">
                    @csrf
                    <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" >

                    <div class="row" id="searchForm">
                        <div class="col-md-12 col-sm-12">
                            <label for="">Customer <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" class="form-control"  placeholder="Search Customer by Name or Phone" id="searchText" name="searchText" autocomplete="off" required>
                                <input type="hidden" class="form-control"   id="customer_id" name="customer_id" autocomplete="off" required>
                                <div id="searchResult" class="list-group"></div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <button type="button" id="addButton" title="Add Customer" class="btn btn-sm btn-info btn-round waves-effect" style="display: block"><i class="zmdi zmdi-plus"></i></button>
                        </div>
                    </div>


                    
                    <div class="row" id="addForm" style="display: none12">
                        <div class="col-md-4 col-sm-12">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Eg. Esther El" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="">Phone <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Eg. 07..." required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" id="address" name="address" class="form-control" placeholder="Eg. Kawe, DSM" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <button type="button" id="searchButton" title="Search Customer" class="btn btn-sm btn-dark btn-round waves-effect"><i class="zmdi zmdi-search"></i></button>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered border-2" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>l
                                            <th>Item Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="products[0][product]" id="searchProduct" class="form-control" placeholder="Search product" required>
                                                <input type="hidden" name="product_id" id="product_id" autocomplete="off">
                                                <input type="hidden" name="product_name" id="product_name" autocomplete="off">
                                                <div id="productResult" class="list-group"></div>
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][price]" id="product_price" min="0" class="form-control" placeholder="Price" readonly required>
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][qty]" id="qty" min="0" class="form-control" placeholder="Quantity" required>
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][unit]" id="unit" min="0" class="form-control" placeholder="Unit" required>
                                            </td>
                                            <td>
                                                <input type="number" name="products[0][total]" id="total" min="0" class="form-control" placeholder="Item Total" readonly required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info btn-raised btn-round waves-effect" id="addRow" title="Add Row"><i class="zmdi zmdi-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <p class="mt-3">Payment Methods:</p>
                            <img src="{{ asset('assets/images/payments/visa.png') }}" alt="Visa">
                            <img src="{{ asset('assets/images/payments/mastercard.png') }}" alt="Mastercard">
                            <img src="{{ asset('assets/images/payments/american-express.png') }}" alt="American Express">
                            <img src="{{ asset('assets/images/payments/paypal2.png') }}" alt="Paypal">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <p class="mt-2 text-right d-flex justify-between">
                                <span class="text-uppercase mr-5">Amount Due: </span>
                                <span class="text-right" name="due_date" id="due_date">{{ date('d/m/Y') }} </span>
                            </p>            
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th class="text-uppercase">Balance (TZS):</th>
                                            <td><input type="number" name="balance_amount" id="balance_amount" class="form-control" placeholder="Balance Amount" value="" readonly></td>
                                        </tr>
                                        <tr>
                                            <th class="text-uppercase">Paid (TZS):</th>
                                            <td><input type="number" name="paid_amount" id="paid_amount" oninput="calculateTotal()" class="form-control" placeholder="Paid Amount" value=""></td>
                                        </tr>
                                        <tr>
                                            <th class="text-uppercase">Total (TZS):</th>
                                            <td><input type="number" name="total_amount" id="total_amount" class="form-control" placeholder="Total Amount" value="" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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

    
    // ADD ROW
    let rowIndex = 1;
    $('#addRow').click(function() {
        let row = `<tr>
                    <td>
                        <input class="form-control" type="text" name="products[${rowIndex}][product]" id="searchProduct" min="0" placeholder="Search product" required>
                        <input type="hidden" name="product_id" id="product_id" autocomplete="off">
                        <input type="hidden" name="product_name" id="product_name" autocomplete="off">
                        <div id="productResult" class="list-group"></div>
                    </td>
                    <td><input class="form-control" type="number" name="products[${rowIndex}][price]" id="product_price" min="0" placeholder="Price" required></td>
                    <td><input class="form-control" type="number" name="products[${rowIndex}][qty]" min="0" placeholder="Quantity" required></td>
                    <td><input class="form-control" type="number" name="products[${rowIndex}][unit]" min="0" placeholder="Unit" required></td>
                    <td><input class="form-control" type="number" name="products[${rowIndex}][item_total]" min="0" placeholder="Item Total" readonly></td>
                    <td><button type="button" title="Delete Row" class="removeRow btn btn-sm btn-danger btn-raised btn-round btn-icon-mini"><i class="zmdi zmdi-delete"></i></button></td>
                </tr>`;
        $('#productsTable tbody').append(row);
        rowIndex++;
    });

    // DELETE ROW
    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
    });

    // SEARCH CUSTOMER
    $("#searchText").on('keyup',function(){
        searchText();
    });

    // SEARCH PRODUCT
    $("#searchProduct").on('keyup',function(){
        searchProduct();
    });

    // HIDE & SHOW CUSTOMER FIELDS
    $("#addButton").click(function(){
        $('#addForm').show();
        $('#searchForm').hide();
        $("#searchButton").show().prop("disabled", false);
        $("#searchText").hide().prop("disabled", true);
    })
     
    $("#searchButton").click(function(){
        $('#addForm').hide();
        $('#searchForm').show();
        $("#searchText").hide().prop("disabled", false);
    })

});


// CLICKING USER RESULTS
function addText(id,name,phone){
    $("#customer_id").val(id)
    $("#searchText").val(name+" ( "+phone+" ) ")
    $("#searchResult").html("")
}

// SEARCH CUSTOMER
function searchText(){
    var searchText=$("#searchText").val();
    $("#customer_id").val("")
    jQuery.ajax({
        type: "GET",
        url: "/search_customer/"+searchText,
        dataType:'html',
        success: function(data) {     
            $("#searchResult").html(data)
        }
    });
}


// ADD PRODUCT
function addProduct(id,name,selling){
    $("#product_id").val(id)
    $("#searchProduct").val(name)
    $("#product_price").val(selling)
    $("#productResult").html("")
}

// SEARCH PRODUCT
function searchProduct(){
    var searchText=$("#searchProduct").val();
    jQuery.ajax({
            type: "GET",
            url: "/search_product/"+searchText,
            dataType:'html',
            success: function(data) {     
                $("#productResult").html(data)
            }

    });
}

// CALCULATE PRODUCT
function calculateTotal() {
    var balance = parseFloat($('#balance_amount').val());
    var paid = parseFloat($('#paid_amount').val());
    if (!isNaN(balance) && !isNaN(paid)) {
        $('#total_amount').val(balance + paid);
    } else {
        $('#total_amount').val('');
    }
}


function getView() {
    jQuery.ajax({
        type: "GET",
        url: "{{ route('sales_view') }}",
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
            $("#name").val(rowData.name);
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
        url: "{{ route('save_sales') }}",
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
