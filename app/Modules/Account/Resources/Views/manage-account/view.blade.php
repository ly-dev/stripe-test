@extends('layouts.app')

@section('content')
@inject('bladeutil', 'App\Services\BladeUtilService')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    @include('components.alert')
                    <h1 class="card-title">{{ isset($model->id) ? 'Edit' : 'Create' }} User</h1>

                    <form id="user-form" method="POST" action="{{ route('manage-account.view', ['id' => $model->id]) }}">
                        {{ csrf_field() }}

                        @include ('components.form-input', [
                            'id' => 'name',
                            'label' => 'Name',
                            'type' => 'text',
                            'value' => old('name', $model->name),
                            'required' => true,
                            'controlAttributes' => 'autofocus'
                        ])

                        @include ('components.form-input', [
                            'id' => 'email',
                            'label' => 'E-Mail Address',
                            'type' => 'email',
                            'value' => old('email', $model->email),
                            'required' => true,
                        ])

                        @include('components.form-select', [
                            'label' => 'Status',
                            'id' => 'status',
                            'value' => old('status', $model->status),
                            'options' => App\Models\User::$STATUS_LABELS,
                            'required' => true,
                        ])
                        
                        @include('components.form-select', [
                            'label' => 'Roles',
                            'id' => 'roles',
                            'value' => old('roles', $bladeutil->columnOfCollection($model->roles, 'id')),
                            'options' => $bladeutil->collectionToOptions(Spatie\Permission\Models\Role::all(), 'id', 'name'),
                            'isMultiple' => true,
                            'required' => true,
                        ]) 

                        @include ('components.form-back-submit', [
                            'backUrl' => route('manage-account.index')
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('component-styles')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('component-scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('select[name="roles[]"]').select2();
    });
</script>
@endpush
