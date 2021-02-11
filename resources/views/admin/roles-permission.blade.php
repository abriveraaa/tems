@extends('adminlte::page')

@section('title', 'Roles & Permission')

@section('content_header')
    <div class="row bg-light p-4 pt-4 d-flex justify-content-between">
        <div class="col-auto">
            <div class="row">
                <div class="col-auto p-0">
                    <div class="info-box bg-light elevation-0">
                        <span class="info-box-icon p-3 bg-danger">
                            <i class="fas fa-book"></i>
                        </span>
                    </div>
                </div>
                <div class="col-auto p-0">
                    <div class="info-box bg-light elevation-0">
                        <div class="info-box-content">
                            <h5 class="info-box-text">Roles and Permission</h5>
                            <span class="info-box-text text-secondary">List of all administrator's roles and permissions in the system.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
@permission('users-view')
    <div class="row p-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="rolesPermission">
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="rolesPermission-table" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th># Roles</th>
                                                <th># Permissions</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>  
                                            @foreach ($users as $user)
                                            <tr>
                                                <td class="td leading-5 text-gray-900">{{$user->name ?? 'The model doesn\'t have a `name` attribute'}}</td>
                                                <td class="td leading-5 text-gray-900">{{$user->roles_count}}</td>
                                                <td class="td leading-5 text-gray-900">{{$user->permissions_count}}</td>
                                                <td class="flex justify-end px-6 py-4 whitespace-no-wrap text-center border-b border-gray-200 text-sm leading-5 font-medium">
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="edit-roles" data-id="{{ $user->id }}" data-model="{{ $modelKey }}" data-toggle="modal" data-target="#editRoles">
                                                        <i class="fas fa-pen mr-2"></i>Edit
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpermission
@permission(['users-create', 'users-update'])
@include('modals.roles-edit')
@endpermission
@stop
@section('footer')
    @include('layout.footer')
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/custom.css') }}">
@stop
@section('js')
<script src="{{ asset('client/js/rolesPermission.js') }}" type="text/javascript"></script>
@stop
