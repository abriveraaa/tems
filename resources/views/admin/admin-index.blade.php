@extends('adminlte::page')

@section('title', 'Admin')

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
                            <h5 class="info-box-text">Administrator's List</h5>
                            <span class="info-box-text text-secondary">List of all the borrowers registered in the system.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @permission('users-create')
        <div class="col-auto d-flex align-items-center">
            <button type="button" class="btn btn-block btn-success" id="admin-add"  data-toggle="modal" data-target="#add-admin">
                <i class="fas fa-plus mr-2"></i>
                <span>Create New</span>
            </button>
        </div>
        @endpermission
    </div>
@stop

@section('content')
@permission('users-view')
    <div class="row p-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="admin">
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="admin-table" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Fullname</th>
                                                <th>Email</th>
                                                <th>Position</th>
                                                <th>Role</th>
                                                <th>Role</th>
                                                <th style="width: 145px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>  
      
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
@include('modals.new-admin')
@endpermission
@permission('users-delete')
@include('modals.delete')
@endpermission
@permission('users-delete')
@include('modals.restore')
@endpermission
@stop
@section('footer')
   @include('layout.footer')
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/custom.css') }}">
@stop
@section('js')
<script src="{{ asset('client/js/admin.js') }}" type="text/javascript"></script>
@stop
