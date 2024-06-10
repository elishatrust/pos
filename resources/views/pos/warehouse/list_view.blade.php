
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Location</th>
                <th>Manager</th>
                <th>Status</th>
                <th>Created By/On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $n=1; @endphp
            @foreach ($data as $item)
            <tr>
                <td>{{ $n }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->user_name }}</td>
                <td>
                    @if (!empty($item->show_status==0))
                    <span class="badge badge-success m-l-10 hidden-sm-down">opened</span>
                    @elseif ($item->show_status==1)
                    <span class="badge badge-warning m-l-10 hidden-sm-down">Closed</span>
                    @endif
                </td>
                <td>
                    <span>{{ $item->user_name }}</span>
                    <p class="mt-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</p>
                </td>
                <td>
                    <button title="Edit Action"  onclick="editWarehouse({{$item->id}})" class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                    <button title="Delete Action" onclick="deleteWarehouse({{$item->id}})"  class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                </td>
            </tr>
            @php $n++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

@include('dependences.datatable')

