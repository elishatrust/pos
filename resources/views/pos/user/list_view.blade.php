
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Full name</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Role</th>
                <th>Warehouse</th>
                <th>Location</th>
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
                <td>{{ $item->name }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->email }}</td>
                <td>
                    @if (!empty($item->role==1))
                    <span class="badge badge-success m-l-10 hidden-sm-down">Admin</span>
                    @elseif ($item->role==2)
                    <span class="badge badge-default m-l-10 hidden-sm-down">Cashier</span>
                    @endif
                </td>
                <td>{{ $item->warehouse_name }}</td>
                <td>{{ $item->location }}</td>
                <td>
                    @if (!empty($item->status==0))
                    <span class="badge badge-success m-l-10 hidden-sm-down">opened</span>
                    @else
                    <span class="badge badge-default m-l-10 hidden-sm-down">Closed</span>
                    @endif
                </td>
                <td>
                    <p class="mt-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</p>
                </td>
                <td>
                    <button title="Edit Action"  onclick="editUser({{$item->id}})" class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-edit"></i></button>
                    <button title="Delete Action" onclick="deleteUser({{$item->id}})"  class="btn btn-icon btn-neutral btn-icon-mini"><i class="zmdi zmdi-delete"></i></button>
                </td>
            </tr>
            @php $n++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

@include('dependences.datatable')

