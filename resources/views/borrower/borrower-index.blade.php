@extends('adminlte::page')

@section('title', 'Borrower')
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
                            <h5 class="info-box-text">Borrower's List</h5>
                            <span class="info-box-text text-secondary">List of all the borrowers registered in the system.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @permission('borrower-create')
        <div class="col-auto d-flex align-items-center">
            <button type="button" class="btn btn-block btn-success" data-toggle="modal" id="borrower-add" data-target="#add-borrower">
                <i class="fas fa-plus mr-2"></i>
                <span>Create New</span>
            </button>
        </div>
        @endpermission
    </div>
@stop

@section('content')
@permission('borrower-view')
    <div class="row p-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="admin">
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="borrower-table" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID Number</th>
                                                <th>Fullname</th>
                                                <th></th>
                                                <th></th>
                                                <th>Sex</th>
                                                <th>Course</th>
                                                <th></th>
                                                <th></th>
                                                <th>Contact</th>
                                                <th></th>
                                                <th style="width:20%">Action</th>
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
        </div>
    </div>
@endpermission
@permission(['borrower-create', 'borrower-update'])
    @include('modals.new-borrower')
@endpermission
@permission('borrower-delete')
    @include('modals.delete')
@endpermission
@permission('borrower-delete')
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
<script src="{{ asset('client/js/borrower.js') }}" type="text/javascript"></script>
@stop
