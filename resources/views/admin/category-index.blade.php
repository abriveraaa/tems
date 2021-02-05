@extends('adminlte::page')

@section('title', 'Tools Categories')

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
                            <h5 class="info-box-text">Tool Categories' List</h5>
                            <span class="info-box-text text-secondary">List of all the tools categories registered in the system.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @permission('toolcategory-create')
        <div class="col-auto d-flex align-items-center">
            <button type="button" class="btn btn-block btn-success" id="add-categories" data-toggle="modal" data-target="#categories">
                <i class="fas fa-plus mr-2"></i>
                <span>Create New</span>
            </button>
        </div>
        @endpermission
    </div>
@stop

@section('content')
@permission('toolcategory-view')
    <div class="row p-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="categories-table" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                    <tr>
                                       
                                    </tr>           
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpermission
@permission(['toolcategory-create', 'toolcategory-update'])
@include('modals.new-category')
@endpermission
@permission('toolcategory-delete')
@include('modals.delete')
@endpermission
@permission('toolcategory-delete')
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
<script src="{{ asset('client/js/category.js') }}" type="text/javascript"></script>
@stop
