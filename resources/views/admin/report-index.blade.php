@extends('adminlte::page')
@section('title', 'Report')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
<style type="text/css" media="print">
    * { display: none; }
</style>
@section('content')
    <div class="row">
        <div class="col-3">
            <div class="callout callout-danger">
                <h6><i class="fas fa-info mr-2"></i>Note:</h6>
                <p>Please choose what type of reports that you want to print</p>
            </div>
        </div>
        <div class="col">
            <div class="callout callout-success">
                <h6>
                    <label for="form-group">Type of Report</label>
                </h6>
                <select class="form-control" id="type" style="width: 100%;">
                    <option value="1">Inventory</option>
                    <option value="2">Item Usage</option>
                    <option value="3">Item List</option>
                    <option value="4">User List</option>
                </select>
            </div>
        </div>
        <div class="col inventory-date">
            <div class="callout callout-success">
                <div class="row">
                    <div class="col">
                        <h6>
                            <label for="form-group" id="title">Choose a Date</label>
                        </h6>
                    </div>
                </div>
                <form id="date" class="mb-0">
                    <div class="row">
                        <div class="col date">
                            <input type="text" class="form-control date-range" id="sam">
                            <input type="hidden" class="form-control" name="start" id="start">
                            <input type="hidden" class="form-control" name="end" id="end">
                        </div>
                        <div class="col type">
                            <select class="form-control" id="subtype" style="width: 100%;">
                                
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-block btn-outline-success btn-flat submit">View</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @permission('report-view')
    <div class="row">
        @include('preview.reported-item')
        @include('preview.serviceable-item')
        @include('preview.inventory-item')
        @include('preview.usage-item')
        @include('preview.active-borrower')
        @include('preview.banned-borrower')
    </div>
    @endpermission
@stop
@section('footer')
   @include('layout.footer')
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/custom.css') }}">
@stop
@section('js')
<script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>   
<script src="{{ asset('client/js/report.js') }}" type="text/javascript"></script>
@stop
