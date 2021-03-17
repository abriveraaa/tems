@extends('adminlte::page')

@section('title', 'Tool')

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
                            <h5 class="info-box-text">Tool's List</h5>
                            <span class="info-box-text text-secondary">List of all the tool's registered in the system.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @permission('tools-create')
        <div class="col-auto d-flex align-items-center">
            <button type="button" class="btn btn-block btn-success" data-toggle="modal" id="tools-add" data-target="#add-tools">
                <i class="fas fa-plus mr-2"></i>
                <span>Create New</span>
            </button>
        </div>
        @endpermission
    </div>
@stop

@section('content')
@permission('tools-view')
    <div class="row">
    <div class="col-auto">
        <div class="info-box mb-3">
            <div class="info-box-content">
                <!-- <span class="info-box-text bg-danger p-1">Unserviceable Items</span> -->
                <span class="info-box-text bg-warning p-1">Borrowed Items</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline outline-red">
            <div class="card-header p-2 bg-gradient">
                <ul class="nav nav-pills float-left">
                    <li class="nav-item"><a class="nav-link active text-uppercase" href="#itemlist" data-toggle="tab">All Items</a></li>
                    <li class="nav-item"><a class="nav-link text-uppercase" href="#categorylist" data-toggle="tab">Categories</a></li>
                    <li class="nav-item"><a class="nav-link text-uppercase" href="#itemnamelist" data-toggle="tab">Item Name</a></li>
                    <li class="nav-item"><a class="nav-link text-uppercase" href="#reportedlist" data-toggle="tab">Unserviceable</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="itemlist">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="alltools-table" class="table table-striped no-wrap" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Item Name</th>
                                            <th>Source</th>
                                            <th>Date Added</th>
                                            <th>Admin</th>
                                            <th>Date Added</th>
                                            <th></th>
                                            <th></th>
                                            <th style="width:20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item">

                                        </tr>                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="categorylist">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="categorylisttable" class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th style="width:25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>              
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="itemnamelist">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="itemnamelist-table" class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th style="width:25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="reportedlist">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="reportedlist-table" class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID Number</th>
                                            <th>Name</th>
                                            <th>Barcode No</th>
                                            <th>Item Name</th>
                                            <th>Brand</th>
                                            <th>Reason</th>
                                            <th>Date Reported</th>
                                            <th>Reported By</th>
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
@permission(['tools-create|tools-update'])
    @include('modals.new-tools')
    @include('modals.modal-category')
@endpermission
@permission('tools-delete')
    @include('modals.delete')
    @include('modals.report-tool')
@endpermission
@permission('tools-delete')
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>   
<script src="{{ asset('client/js/tools.js') }}" type="text/javascript"></script>
@stop
