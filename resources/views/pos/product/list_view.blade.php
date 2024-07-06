
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Batch</th>
                <th>Product</th>
                <th>Barcode</th>
                {{-- <th>Cost</th> --}}
                <th>Selling(TZS)</th>
                <th>InStock</th>
                {{-- <th>MFT Date</th> --}}
                <th>Exp Date</th>
                <th>Warehouse</th>
                <th>Category</th>
                <th>Supplier</th>
                <th>Status</th>
                <th>Created On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $n=1; @endphp
            @foreach ($data as $item)
            <tr>
                <td>{{ $n }}</td>
                <td>{{ $item->batch }}</td>
                <td>{{ $item->name }}</td>
                <td>
                    {!! $item->bar_code !!}
                    <p>P - {{ $item->barcode }}</p>
                </td>
                {{-- <td>{{ $item->cost }}</td> --}}
                <td>{{ number_format($item->selling) }}</td>
                <td>{{ number_format($item->qty) }}</td>
                {{-- <td>{{ \Carbon\Carbon::parse($item->mft_date)->format('d-m-Y') }}</td> --}}
                <td>{{ \Carbon\Carbon::parse($item->exp_date)->format('d-m-Y') }}</td>
                <td>{{ $item->warehouse_name }}</td>
                <td>{{ $item->category_name }}</td>
                <td>{{ $item->user_name }}</td>
                <td>
                    @if (!empty($item->status==0))
                    <span class="badge badge-success m-l-10 hidden-sm-down">Instock</span>
                    @else
                    <span class="badge badge-default m-l-10 hidden-sm-down">OutStock</span>
                    @endif
                </td>
                <td>
                    <p class="mt-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</p>
                </td>
                <td>
                    <button title="Edit Action"  onclick="editProduct({{$item->id}})" class="btn btn-icon btn-neutral btn-icon-mini234"><i class="zmdi zmdi-edit"></i></button>
                    <button title="Delete Action" onclick="deleteProduct({{$item->id}})"  class="btn btn-icon btn-neutral btn-icon-mini234"><i class="zmdi zmdi-delete"></i></button>
                </td>
            </tr>
            @php $n++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

@include('dependences.datatable')

