
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Barcode</th>
                <th>Batch</th>
                <th>Product</th>
                <th>Category</th>
                <th>Purchase(TZS)</th>
                <th>Selling(TZS)</th>
                <th>Discount(TZS)</th>
                <th>Stock</th>
                <th>Status</th>
                {{-- <th>Created On</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $n=1; @endphp
    
            @foreach ($data as $item)
            <tr>
                <td>{{ $n }}</td>
                <td title="Barcode">
                    {!! $item->bar_code !!}
                    <p>PQ{{ $item->barcode }}</p>
                </td>
                <td title="Batch">{{ $item->batch }}</td>
                <td title="Product">{{ $item->product }}</td>
                <td title="Category">{{ $item->category_name }}</td>
                <td title="Purchase Price">{{ number_format($item->purchase_price) }}</td>
                <td title="Selling Price">{{ number_format($item->selling_price) }}</td>
                <td title="Discount">{{ number_format($item->discount) }}</td>
                <td title="Stock">{{ $item->stock }}</td>
                <td title="Status">
                    @if ($item->stock > 0)
                    <span class="badge badge-success m-l-10 hidden-sm-down p-2">Instock</span>
                    @else
                    <span class="badge badge-default m-l-10 hidden-sm-down p-2">OutStock</span>
                    @endif
                </td>
                {{-- <td>
                    <span>{{ $item->user_name }}</span>
                    <p class="">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</p>
                </td> --}}
                <td title="Action">
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Edit Action"  onclick="editProduct({{$item->id}})">
                        <i class="zmdi zmdi-edit text-info"></i>
                    </button>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Delete Action" onclick="deleteProduct({{$item->id}})">
                        <i class="zmdi zmdi-delete text-danger"></i>
                    </button>
                </td>
            </tr>
            @php $n++; @endphp
            @endforeach

        </tbody>
    </table>
</div>

@include('dependences.datatable')

