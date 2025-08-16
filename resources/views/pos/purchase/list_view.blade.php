
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Supplier</th>
                <th>Items</th>
                <th>Price</th>
                <th>Discount(%)</th>
                <th>NetDiscount</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $n=1;
                $AllTotalItem = 0; 
                $AllTotalPrice = 0; 
                $AllTotalDiscount = 0; 
                $AllTotalNetDiscount = 0; 
                $AllTotalPrice2 = 0; 

            @endphp

            @foreach ($data as $item)

            @php

                $NetDiscount = ($item->total_price * $item->discount / 100);
                $TotalPrice = ($item->total_price - $NetDiscount);

                $AllTotalItem = $AllTotalItem + $item->total_item;
                $AllTotalPrice = $AllTotalPrice + $item->total_price;
                $AllTotalDiscount = $AllTotalDiscount + $item->discount;
                $AllTotalNetDiscount = $AllTotalNetDiscount + $NetDiscount;
                $AllTotalPrice2 = $AllTotalPrice2 + $TotalPrice;
            @endphp

            <tr>
                <td>{{ $n }}</td>
                <td>{{ $item->supplier_name }}</td>
                <td>{{ $item->total_item }}</td>
                <td>{{ $item->total_price }}</td>
                <td>{{ $item->discount }}</td>
                <td>{{ $NetDiscount }}</td>
                <td>{{ $TotalPrice }}</td>
                <td>
                    @if (!empty($item->status==0))
                    <span class="badge badge-success m-l-10 hidden-sm-down">Active</span>
                    @elseif ($item->status==1)
                    <span class="badge badge-warning m-l-10 hidden-sm-down">Inactive</span>
                    @endif
                </td>
                <td>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="View Action"  onclick="ViewPurchase123({{$item->id}})">
                        <a href="/admin/purchase-details/{{ $item->id }}"><i class="zmdi zmdi-eye col-amber"></i></a>
                    </button>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Edit Action"  onclick="editPurchase({{$item->id}})">
                        <i class="zmdi zmdi-edit text-info"></i>
                    </button>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Delete Action" onclick="deletePurchase({{$item->id}})">
                        <i class="zmdi zmdi-delete text-danger"></i>
                    </button>
                </td>
            </tr>
            @php $n++; @endphp
            @endforeach
            
            <tr style="font-weight: 900">
                <td colspan="2">ALL TOTAL</td>
                <td>{{ number_format($AllTotalItem,2) }}</td>
                <td>{{ number_format($AllTotalPrice,2) }}</td>
                <td>{{ number_format($AllTotalDiscount,2) }}</td>
                <td>{{ number_format($AllTotalNetDiscount,2) }}</td>
                <td>{{ number_format($AllTotalPrice2,2) }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</div>

@include('dependences.datatable')

