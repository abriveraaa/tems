@extends('adminlte::page')

@section('title', 'Transaction')
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
                            <h5 class="info-box-text">LHOF - Transactions</h5>
                            <span class="info-box-text text-secondary">List of all the lhos's registered in the system.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
<div class="row p-3">
        <div class="col-md-12">
            <div class="card card-primary card-outline outline-red">
                <div class="card-header p-2 bg-gradient">
                    <ul class="nav nav-pills float-left">
                        <li class="nav-item"><a class="nav-link active" href="#lhof" data-toggle="tab">LHOF</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="lhof">
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="lhoftable" class="table table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>LHOF No</th>
                                                <th>Quantity</th>
                                                <th>ID Number</th>
                                                <th>Name</th>
                                                <th>Room</th>
                                                <th>Date | Time</th>
                                                <th style="width:15%">Action</th>
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
@include('modals.lhof-data')

@stop
@section('footer')
   @include('layout.footer')
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/custom.css') }}">
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>   
<script src="{{ asset('client/js/transaction.js') }}" type="text/javascript"></script>
@stop
