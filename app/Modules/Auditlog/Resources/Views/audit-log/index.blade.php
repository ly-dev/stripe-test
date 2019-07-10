@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-5">
            <div class="col-sm-10">

<h1>Audit Logs</h1>
<table class="table table-striped table-hover" id="data-table">
    <thead>
        <tr>
            <th>Timestamp</th>
            <th>Severity</th>
            <th>Category</th>
            <th>Activity</th>
            <th>IP&nbsp;Address</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

        </div>
    </div>
</div>
@endsection

@push('component-styles')
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('component-scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){

		var dataTable = $('#data-table').DataTable({
		    "processing": true,
		    "serverSide": true,
		    "order": [[ 0, "desc" ]],
            "searching": true,
            "responsive": true,
		    "ajax": "{{url('audit-log/grid')}}",
		    "columns": [
                {
                    "data": "updated_at"
                },
                {
                    "data": "severity"
                },
                {
                    "data": "category"
                },
                {
                	"orderable": false,
                    "data": "activity"
                },
                {
                    "data": "ip_address"
                },
                {
                    "data": "userEmail"
                }
		    ]
		});
	});
</script>
@endpush
