@extends('layouts.app')
@section('title_for_layout', 'Detail Products Management')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/detail-product-list.css') }}" rel="stylesheet">
@endsection
@section('bread')
{{ Breadcrumbs::render('products-detail')}}
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div style="width: 100%" class="card">
            <div class="card-body">
                <div class="row py-2">
                    <div class="col-md-6">
                        <div class="heading">
                            <h2>List Products Detail</h2>
                        </div>
                    </div>
                </div>
                <div class="row mb-2 tool-search">
                    <div class="col-lg-7 filter-wrapper">
                        <div class="filter-field" style="width: 175px; padding-left: 15px">
                            <input type="text" style="height: 37.4px"  class="form-control" id="filter-name" placeholder="Seach...">
                        </div>
                    </div>

                </div>
                <div class="table-responsive custom-table">
                    <table id="datatableProducDetail" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                            <tr>
                                <th width="6%">No</th>
                                <th style="text-align: center">Image</th>
                                <th style="text-align: center">Name</th>
                                <th style="text-align: center">Code card</th>
                                <th style="text-align: center">Game acount</th>
                                <th style="text-align: center">Password account</th>
                                <th style="text-align: center" width="14%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('after-scripts')
    <script src="{{ asset('assets/js/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('assets/js/sweetalert2/sweet-alert.init.js')}}"></script>
    <script src="{{ asset('assets/js/krunk.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
         
            var table = $('#datatableProducDetail').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                order: [[ 0, 'desc' ]],
                ajax: {
                    url: '{{ route('detail-products.datatable') }}',
                    data: function (d) {
                        d.search = $('#filter-name').val()
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className:'text-center align-middle'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        className:'text-center align-middle'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className:'text-center align-middle'
                    },
                    {
                        data: 'code_card',
                        name: 'code_card',
                        className:'text-center align-middle'
                    },
                    {
                        data: 'account_game',
                        name: 'account_game',
                        className:'text-center align-middle'
                    },
                    {
                        data: 'password_game',
                        name: 'password_game',
                        className:'text-center align-middle'
                    },
                    {
                        data: 'action',
                        name: 'action', 
                        orderable: false, searchable: false,
                        className:'text-center align-middle'
                    }
                ]
            })

            $("#filter-name").keyup(function(){
                table.draw();
            });

            $('body').on('click', '.btn-delete', function (e) {
                e.preventDefault();
                var me = $(this),
                    url = me.attr('href'),
                    id =  me.attr('data-id'),
                    csrf_token = $('meta[name="csrf-token"]').attr('content');
                swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to delete this detail product?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: "#DD6B55",
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                'id':id,
                                '_method' : 'DELETE',
                                '_token' : csrf_token,
                            },
                            success: function (data) {
                                if(data.success == true){
                                    // drawDatatable();
                                    table.draw();
                                    toastr.success(data.message);
                                }
                            },
                            error: function(xhr){
                                Swal.fire({
                                    type: 'info',
                                    title: '',
                                    text: 'Delete Fail',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    }
                });
            })
        });
    </script>
@endpush
