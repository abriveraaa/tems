@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="small-box bg-success">
                <div class="inner inventorylist">
                    <h3 id="toolscount">0</h3>
                    <p>Inventory List</p>
                </div>
                <div class="icon">
                    <i class="ion ion-hammer"></i>
                </div>
            </div>
            <div class="row borrower">
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="activecount">0</h3>
                            <p>Active Borrowers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="bannedcount">0</h3>
                            <p>Banned Borrowers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title text-uppercase">Borrowed Items</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0  borrow-item">
                    <ul class="products-list borrow-list product-list-in-card pl-2 pr-2" id="sample">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title text-secondary text-uppercase">Transaction Monitoring</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                    <p class="d-flex flex-column">
                        <span>Transaction Over Time</span>
                    </p>
                    
                    </div>
                    <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="visitors-chart" height="200" width="487" class="chartjs-render-monitor" style="display: block; width: 487px; height: 200px;"></canvas>
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Transaction
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @permission('transaction-view')
    @include('modals.lhof-data')
    @endpermission
    @include('modals.inventory-list')
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
<script src="{{ asset('client/js/dashboard.js') }}" type="text/javascript"></script>
@stop
