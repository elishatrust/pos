
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Order Amt</th>
                <th>Return Amt</th>
                <th>Disc</th>
                <th>Prev Bal</th>
                <th>Bill Paid</th>
                <th>Balance</th>
                <th>Profit</th>
                <th>User</th>
                <th>Created On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $n=1; @endphp
            {{-- @foreach ($data as $item)
            <tr>
                <td>{{ $n }}</td>
                <td>{{ $item->batch }}</td>
                <td>{{ $item->name }}</td>
                {{-- <td>{{ $item->cost }}</td> --}}
                {{-- <td>{{ $item->selling }}</td> --}}
                {{-- <td>{{ $item->qty }}</td> --}}
                {{-- <td>{{ \Carbon\Carbon::parse($item->mft_date)->format('d-m-Y') }}</td> --}}
                {{-- <td>{{ \Carbon\Carbon::parse($item->exp_date)->format('d-m-Y') }}</td>
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
            @endforeach --}}
        </tbody>
    </table>
</div>

@include('dependences.datatable')

