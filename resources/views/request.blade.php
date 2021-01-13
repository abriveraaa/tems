@extends('adminlte::page')

@section('title', 'Request')

@section('content')
<div class="head-search row bg-light">
    <div class="col-3 center-search">
        <input type="text" class="form__search" name="borrowernum" id="borrowernum" placeholder="ID NUMBER" autocomplete="off">
    </div>
</div>
<div class="row pt-4 authenticate d-flex justify-content-center">
    <div class="col transaction">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title text-uppercase">Transactions</h3>
                <div class="card-tools">                        
                </div>
            </div>
            <div class="card-body overflow">
                <div class="table-responsive">
                    <table id="transactuser" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>LHOF No</th>
                                <th>Date/ Time</th>
                                <th>Room</th>
                                <th style="width:25%">Action</th>
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
@include('modals.borrow-tool')
@include('modals.lhof-data')
@stop
@section('footer')
    <div class="float-left d-none d-sm-block">
        <strong>Copyright © {{ now()->year }}.</strong> All rights reserved.
    </div>
    <div class="float-right d-none d-sm-block">
        <strong><a href="#">{{ config('adminlte.name') }}</a></strong>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/custom.css') }}">
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>   
<script src="{{ asset('client/js/request.js') }}" type="text/javascript"></script>
@stop
