@extends('adminlte::page')

@section('title', 'Source')

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
                            <h5 class="info-box-text">Source's List</h5>
                            <span class="info-box-text text-secondary">List of all the sources registered in the system.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @permission('room-create')
        <div class="col-auto d-flex align-items-center">
            <button type="button" class="btn btn-block btn-success" id="add-source" data-toggle="modal" data-target="#source">
                <i class="fas fa-plus mr-2"></i>
                <span>Create New</span>
            </button>
        </div>
        @endpermission
    </div>
@stop

@section('content')
@permission('source-view')
    <div class="row p-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="source-table" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Source Description</th>
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
    
    @permission(['source-create', 'source-update'])
    @include('modals.new-source')
    @endpermission
    @permission('source-delete')
    @include('modals.delete')
    @endpermission
    @permission('source-delete')
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
<script src="{{ asset('client/js/source.js') }}" type="text/javascript"></script>
@stop
