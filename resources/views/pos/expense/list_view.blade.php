
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Amount(TZS)</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $TotalAmount=0; $n=1; @endphp
            @foreach ($data as $item)
            @php
                $TotalAmount = $TotalAmount + $item->amount;
            @endphp
            <tr>
                <td>{{ $n }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->amount }}</td>
                <td>
                    @if (!empty($item->show_status==0))
                    <span class="badge badge-success m-l-10 hidden-sm-down">Active</span>
                    @elseif ($item->show_status==1)
                    <span class="badge badge-warning m-l-10 hidden-sm-down">Inactive</span>
                    @endif
                </td>
                <td>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Edit Action"  onclick="editExpense({{$item->id}})">
                        <i class="zmdi zmdi-edit text-info"></i>
                    </button>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Delete Action" onclick="deleteExpense({{$item->id}})">
                        <i class="zmdi zmdi-delete text-danger"></i>
                    </button>
                </td>
            </tr>
            @php $n++; @endphp
            @endforeach
            <tr style="font-weight: 900">
                <td colspan="3">TOTAL</td>
                <td colspan="3">{{ number_format($TotalAmount,2) }}</td>
            </tr>
        </tbody>
    </table>
</div>

@include('dependences.datatable')

