
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Total Item</th>
                <th>Total Price</th>
                <th>Discount</th>
                <th>Accept</th>
                <th>Created</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $n=1; 
                $TotalItem = 0;
                $TotalPrice = 0;
                $TotalDiscount = 0;            
            @endphp

            @foreach ($data as $item)

            @php
                $TotalItem = $TotalItem + $item->total_item;
                $TotalPrice = $TotalPrice + $item->total_price;
                $TotalDiscount = $TotalDiscount + $item->discount;                
            @endphp

            <tr>
                <td>{{ $n }}</td>
                <td>{{ $item->customer_name }}</td>
                <td>{{ number_format($item->total_item,2) }}</td>
                <td>{{ number_format($item->total_price,2) }}</td>
                <td>{{ number_format($item->discount,2) }}</td>
                <td>{{ $item->accept }}</td>
                <td>
                    <span class="mt-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y|H:m:i') }}</span>
                </td>
                <td>
                    @if (!empty($item->status==0))
                    <span class="badge badge-success m-l-10 hidden-sm-down">Active</span>
                    @elseif($item->status==1)
                    <span class="badge badge-default m-l-10 hidden-sm-down">Inactive</span>
                    @endif
                </td>
                <td>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Edit Action"  onclick="editSales({{$item->id}})">
                        <i class="zmdi zmdi-edit text-info"></i>
                    </button>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Delete Action" onclick="deleteSales({{$item->id}})">
                        <i class="zmdi zmdi-delete text-danger"></i>
                    </button>
                </td>
            </tr>
            @php $n++; @endphp
            @endforeach 
            <tr style="font-weight: 900">
                <td colspan="2">ALL TOTAL</td>
                <td>{{ number_format($TotalItem,2) }}</td>
                <td>{{ number_format($TotalPrice,2) }}</td>
                <td colspan="5">{{ number_format($TotalDiscount,2) }}</td>
            </tr>
        </tbody>
    </table>
</div>

@include('dependences.datatable')

