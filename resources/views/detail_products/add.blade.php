@extends('layouts.app')
@section('title_for_layout', 'Create Product')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        button a {
            width: 100%;
            height: 100%;
            color: #ccc;
        }

        html {
            font-size: 14px
        }

        .card-title {
            margin-bottom: 30px !important;
        }
        .wrapper {
            padding-left: 30px
        }

        textarea {
            padding: 6px 12px
        }

        .action button {
            min-width: 70px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('bread')
{{ Breadcrumbs::render('add_product-detail', $idProduct)}}
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Create Detail Product</h3>
                <form method="POST" id="form_point" enctype="multipart/form-data" action="{{ route('detail-products.store') }}">
                    @csrf
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label for="name">Name <span class="help text-danger">*</span></label>
                            <input readonly type="text" class="form-control" id="name" name="name"
                            placeholder="Name"
                            value="{{ $nameProduct }}">
                        </div>
                    </div>
                    <input name="id_product" value="{{ $idProduct }}" type="hidden"/>
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label for="code_card">Code Card <span class="help text-danger"></span></label>
                            <input type="text" class="form-control" id="code_card" name="code_card"
                            placeholder="Code Card"
                            value="{{ old('code_card') }}">
                            @if ($errors->has('code_card'))
                            <span class="text-danger pt-2">{{ $errors->first('code_card') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label for="game_account">Game Account <span class="help text-danger"></span></label>
                            <input type="text" class="form-control" id="game_account" name="game_account"
                            placeholder="Game Account"
                            value="{{ old('game_account') }}">
                            @if ($errors->has('game_account'))
                            <span class="text-danger pt-2">{{ $errors->first('game_account') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label for="password_account">Game Account <span class="help text-danger"></span></label>
                            <input type="text" class="form-control" id="password_account" name="password_account"
                            placeholder="Password Account"
                            value="{{ old('password_account') }}">
                            @if ($errors->has('password_account'))
                            <span class="text-danger pt-2">{{ $errors->first('password_account') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row d-flex justify-content-center action" style="margin-top: 14px">
                        <a href="{{ route('detail-products.index') }}"><button style="margin-right: 10px" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button></a>
                        <button type="submit" class="btn btn-success btn_save_meals" id="addMenu">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script src="{{ asset('assets/js/ckeditor5/build/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script src="{{ asset('assets/js/sweetalert2/sweet-alert.init.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        
    </script>
@endpush
