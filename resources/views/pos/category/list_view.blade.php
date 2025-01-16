
<div class="table-responsive">
    <table class="table table-hover m-b-0 c_list table-bordered table-striped table-hover js-basic-example dataTable" id="tableId">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th>Created By/On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $n = 1; @endphp
        
            @if ($data->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">No data available</td>
                </tr>
            @else
                @foreach ($data as $item)
                <tr>
                    <td>{{ $n }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        @if (!empty($item->status == 0))
                        <span class="badge badge-success m-l-10 hidden-sm-down">Active</span>
                        @else
                        <span class="badge badge-default m-l-10 hidden-sm-down">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <span>{{ $item->user_name }}</span>
                        <p class="mt-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</p>
                    </td>
                    <td>
                        <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Edit Action" onclick="editCategory({{ $item->id }})">
                            <i class="zmdi zmdi-edit text-info"></i>
                        </button>
                        <button class="badge badge-default btn-icon btn-icon-mini p-2" title="Delete Action" onclick="deleteCategory({{ $item->id }})">
                            <i class="zmdi zmdi-delete text-danger"></i>
                        </button>
                    </td>
                </tr>
                @php $n++; @endphp
                @endforeach
            @endif
        </tbody>        
    </table>
</div>

@include('dependences.datatable')

