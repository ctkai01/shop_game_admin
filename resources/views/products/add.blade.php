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
{{ Breadcrumbs::render('add_product')}}
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Create Product</h3>
                <form method="POST" id="form_point" enctype="multipart/form-data" action="{{ route('products.store') }}">
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
                        <label>Images <span class="help text-danger">*</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" accept="image/*" class="custom-file-input"
                                    id="image">
                                <label class="custom-file-label image"
                                    for="image">Choose file</label>
                            </div>
                        </div>
                        <span class="text-danger" id="error-image" style="display: none;"></span>
                        @if ($errors->has('image'))
                        <span class="text-danger pt-2 error-image">{{ $errors->first('image') }}</span>
                        @endif
                        <div class="mt-3 mb-3 preview-img preview-image" style="width: 150px;">
                            <img id="ImgPreview" src="{{ asset('images/no-image.png') }}"
                            width="100%" />
                        </div>
                    </div>
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label>Category <span class="help text-danger">*</span></label>
                            <select style="width: 100%" class="js-example-basic-multiple" name="categories[]" multiple="multiple">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('categories'))
                                <span class="text-danger pt-2 error-product">{{ $errors->first('categories') }}</span>
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
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label>Price<span class="help text-danger"> *</span></label>
                            <input type="text" class="form-control" value="{{ old('price') }}" id="price" name="price" placeholder="Price" value="">
                            @if ($errors->has('price'))
                                <span class="text-danger pt-2">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label>Discount<span class="help text-danger"> *</span></label>
                            <input type="text" class="form-control" value="{{ old('discount') }}" id="discount" name="discount" placeholder="Discount" value="">
                            @if ($errors->has('discount'))
                                <span class="text-danger pt-2">{{ $errors->first('discount') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label>Count<span class="help text-danger"> *</span></label>
                            <input type="text" class="form-control" value="{{ old('count') }}" id="count" name="count" placeholder="Count" value="">
                            @if ($errors->has('count'))
                                <span class="text-danger pt-2">{{ $errors->first('count') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 field-input" style="padding-left: 0px">
                        <div class="form-group" style="text-align: left">
                            <label>Description <span class="help text-danger">*</span></label>
                            <textarea name="description" id="description" value="{{ old('description') }}">
                               
                            </textarea>
                        </div>
                   
                    </div>
                    
                    <div class="row d-flex justify-content-center action" style="margin-top: 14px">
                        <a href="{{ route('products.index') }}"><button style="margin-right: 10px" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button></a>
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
        function readURL(input, imgControlName) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                      $(imgControlName).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        (function() {
            $('#form_interest').on('submit', function(e) {
                e.stopImmediatePropagation();
                $("#btn-save").attr('disabled', 'true');

            })
        })();
        ;
        $(document).ready(function (){
            $('.js-example-basic-multiple').select2({closeOnSelect:false});
            
            ClassicEditor
            .create( document.querySelector("#description"), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'fontfamily', 'fontsize', '|',
                        'alignment', '|',
                        'fontColor', 'fontBackgroundColor', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                        'link', '|',
                        'outdent', 'indent', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'code', 'codeBlock', '|',
                        'insertTable', '|',
                        'uploadImage', 'blockQuote', '|',
                        'undo', 'redo'
                    ],
                }
            })
            .catch( error => {
                console.error( error );
            } );
            $('#image').bind('change', function () {
                var a = 1;
                var ext = $(this).val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg']) == -1) {
                    $('#error-image').html('The image is not in the correct format! Picture format must be JPG, JPEG, PNG or GIF.');
                    $('#error-image').slideDown("slow");
                    $('.error-image').hide();
                    $('#image').val("");
                    a = 0;
                } else {

                    var picsize = (this.files[0].size);
                    if (picsize > 1024*1024*10) {
                        $('#error-image').html('The image cannot be larger than 10MB.');
                        $('#error-image').show();
                        $('.error-image').hide();
                        $('#image').val("");
                        a = 0;
                    } else {
                        a = 1;
                        $('#error-image').slideUp("slow");
                        $('.error-image').hide();
                    }
                    if (a == 1) {
                        $('#error-image').slideUp("slow");
                        var imgControlName = "#ImgPreview";
                        readURL(this, imgControlName);
                        $('.preview-image').show();
                    }
                }
            });
        })
    </script>
@endpush
