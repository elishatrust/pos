
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Supplier</th>
                <th>Total Item</th>
                <th>Total Price(TZS)</th>
                <th>Discount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $n=1; @endphp
            @foreach ($data as $item)
            <tr>
                <td>{{ $n }}</td>
                <td>{{ $item->supplier_name }}</td>
                <td>{{ $item->total_item }}</td>
                <td>{{ $item->total_price }}</td>
                <td>{{ $item->discount }}</td>
                <td>
                    @if (!empty($item->status==0))
                    <span class="badge badge-success m-l-10 hidden-sm-down">Active</span>
                    @elseif ($item->status==1)
                    <span class="badge badge-warning m-l-10 hidden-sm-down">Inactive</span>
                    @endif
                </td>
                <td>
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
        </tbody>
    </table>
</div>

@include('dependences.datatable')

