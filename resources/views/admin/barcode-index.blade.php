@extends('adminlte::page')

@section('title', 'Barcodes')

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
                            <h5 class="info-box-text">Barcodes' List</h5>
                            <span class="info-box-text text-secondary">List of all the barcodes registered in the system.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header p-2">
                <div class="row no-print">
                    <div class="col-12">
                        @permission('barcode-print')
                        <a href="{{ url('/report/barcodeall') }}" target="_blank" class="btn btn-outline-secondary btn-flat"><i class="fas fa-download"></i> PDF</a>
                        @endpermission
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="printable">
                    <div class="row text-center">
                        @foreach($barcode as $bar)
                        <div class="col">
                            <div>{!! DNS1D::getBarcodeSVG($bar->barcode, "C39", 1, 35) !!}</div><br>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('footer')
    @include('layout.footer')
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/custom.css') }}">
@stop
@section('js')
<script src="{{ asset('client/js/barcodes.js') }}" type="text/javascript"></script>
@stop
