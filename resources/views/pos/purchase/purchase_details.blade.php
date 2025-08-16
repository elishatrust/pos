
@extends('pos.layouts.app')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
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
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2 class="text-uppercase">{{ $data['header' ]}}</h2>
                    <ul class="breadcrumb ">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="javascript:">App</a></li>
                        <li class="breadcrumb-item active">{{ $data['header' ]}}</li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12 justify-content-end">
                    <a href="#largeModal" onclick="clear_input()" data-toggle="modal" data-target="#largeModal" title="Add New" class="float-right mx-4" style="transform:scale(2.0)">
                        <i class="zmdi zmdi-plus-circle"></i>
                    </a>
                    <a href="{{ route('admin-purchase') }}" class="float-right mx-4" title="Back" style="transform:scale(2.0)">
                        <i class="zmdi zmdi-mail-reply m-r-0"></i>
                    </a>
                </div>
            </div>
        </div>      

        <div class="row clearfix">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        
                        {{-- <div id="getView">
                            <img src="{{ asset('assets/loader.svg') }}" alt="">
                        </div> --}}

                        <div class="table-responsive">
                            <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Purchase Name</th>
                                        <th>Purchase Price</th>
                                        <th>Amount(TZS)</th>
                                        <th>Sub Total(TZS)</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $n=1; @endphp
                                    @foreach ($purchase_details as $item)                         
                                    <tr>
                                        <td>{{ $n }}</td>
                                        <td>{{ $item->purchase_id }}</td>
                                        <td>{{ $item->product_id }}</td>
                                        <td>{{ $item->purchasePrice }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->sub_total }}</td>
                                        <td>{{ date('d-m-Y H:s A', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @if (!empty($item->status==0))
                                            <span class="badge badge-success m-l-10 hidden-sm-down">Active</span>
                                            @elseif ($item->status==1)
                                            <span class="badge badge-warning m-l-10 hidden-sm-down">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Edit Action"  onclick="editPurchaseDetail({{$item->id}})">
                                                <i class="zmdi zmdi-edit text-info"></i>
                                            </button>
                                            <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Delete Action" onclick="deletePurchaseDetail({{$item->id}})">
                                                <i class="zmdi zmdi-delete text-danger"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @php $n ++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Purchase Details</h4><strong class="text-danger float-right">Required *</strong>
            </div>
            <div class="modal-body">
                <form id="form" onsubmit="save(event)" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" id="hidden_id" name="hidden_id" >
                    <input type="hidden" class="form-control" id="purchase_id" name="purchase_id" value="{{ $purchase_id }}" >
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <label for="">Product Name <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-control show-tick" required>
                                <option>~Select~</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Purchase Price <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="purchase_price" name="purchase_price" class="form-control" placeholder="Total purchase price" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Amount <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="amount" name="amount" class="form-control" placeholder="Total amount" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">SubTotal <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="number" id="sub_total" name="sub_total" class="form-control" placeholder="Sub total" min="0" required>
                            </div>
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
        closeModel();
        getPurchaseDetails();
    });
    
    
    function clear_input() {
        document.getElementById('form').reset();
        $("#hidden_id").val("")
        getView()
    }
    
    function closeModel(){
        $('#largeModal').modal('hide');
    }


    function save(e) {
        e.preventDefault();

        var form = document.getElementById('form');
        var formData = new FormData(form);

        jQuery.ajax({
            type: "POST",
            url: "{{ route('admin-purchase-details-save') }}",
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
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showFlashMessage("error", "Something went wrong.");
            }
        });
    }
    

</script>
@endsection

