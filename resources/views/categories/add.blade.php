@extends('layouts.app')
@section('title_for_layout', 'Create Category')
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
@endsection
@section('bread')
{{ Breadcrumbs::render('add_category')}}
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Create Category</h3>
                <form method="POST" id="form_point" enctype="multipart/form-data" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label for="name">Name <span class="help text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                            placeholder="Name"
                            value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            <span class="text-danger pt-2">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label for="slug">Slug <span class="help text-danger">*</span></label>
                            <input type="text" class="form-control" id="slug" name="slug"
                            placeholder="Slug"
                            value="{{ old('slug') }}">
                            @if ($errors->has('slug'))
                            <span class="text-danger pt-2">{{ $errors->first('slug') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center action">
                        <a href="{{ route('categories.index') }}"><button style="margin-right: 10px" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button></a>
                        <button type="submit" class="btn btn-success btn_save_meals" id="addMenu">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
    {{-- <script src="{{ asset('assets/js/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('assets/js/sweetalert2/sweet-alert.init.js')}}"></script> --}}

    <script>

        $(document).ready(function (){
            (function() {
                $('#form_point').on('submit', function() {
                    $("#addMenu").attr('disabled', 'true');
                })
            })();
        })
    </script>
@endpush
