
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Full name</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Location</th>
                <th>Code</th>
                <th>Role</th>
                <th>Status</th>
                {{-- <th>Created On</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $n=1; @endphp
            @foreach ($data as $item)
            <tr>
                <td title="ID">{{ $n }}</td>
                <td title="Full Name">{{ $item->name }}</td>
                <td title="Username">{{ $item->username }}</td>
                <td title="Phone Number">{{ $item->phone }}</td>
                <td title="Email">{{ $item->email }}</td>
                <td title="Location">{{ $item->location }}</td>
                <td title="User Code">{{ $item->user_code }}</td>
                <td title="Role">
                    @if (!empty($item->role==1))
                    <span class="text-danger">Admin</span>
                    @elseif ($item->role==2)
                    <span class="text-default">Member</span>
                    @endif
                </td>
                <td title="Status">
                    @if (!empty($item->status==0))
                    <span class="badge badge-success m-l-10 hidden-sm-down px-2">Active</span>
                    @else
                    <span class="badge badge-default m-l-10 hidden-sm-down px-2">Inactive</span>
                    @endif
                </td>
                {{-- <td><p class="mt-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</p></td> --}}
                <td title="Action">
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Edit Action"  onclick="editUser({{$item->id}})">
                        <i class="zmdi zmdi-edit text-info"></i>
                    </button>
                    <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Delete Action" onclick="deleteUser({{$item->id}})">
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

