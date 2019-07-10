@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-5">
            <div class="col-sm-10">

<h1>Users</h1>
<table class="table table-striped table-hover" id="data-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Roles</th>
            <th>Updated At</th>
            <th style="width: 50px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-sm-10">
            @include ('components.link-button', [
                'label' => 'Add New User',
                'href' => route('manage-account.view'),
            ])
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
<script src="{{ asset('js/app-datatable.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        var columns = [
            {
                "data": "name",
            },
            {
                "data": "email"
            },
            {
                "data": "status",
            },
            {
                "orderable": false,
                "data": "roles",
            },
            {
                "data": "updated_at"
            }
        ];

        var dataTable = $('#data-table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "responsive": true,
            "ajax": "{{ route('manage-account.grid') }}",
            "columns": columns.concat([
                {
                    "orderable": false,
                    "render": function render( data, type, row, meta ) {
                        var html = '<a href="' + "{{ route('manage-account.view') }}" + '/' + row.id + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>' +
                            '&nbsp;<a href="#" data-action-type="delete" data-action-params="' + row.id +'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        return html;
                    }

                }
            ])
        }).on( 'draw', function () {
            // register actions
            $('a[data-action-type="delete"]').click(function(event) {
                event.preventDefault();
                event.stopPropagation();

                var params = $(this).data('action-params');
                var options = {
                    url: "{{ route('manage-account.delete', ['id' => null ]) }}" + '/' + params
                };

                return myappUtil.dataTableDoRowDelete(dataTable, options);
            });
        });
    });
</script>
@endpush
