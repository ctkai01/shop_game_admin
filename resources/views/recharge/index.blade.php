@extends('layouts.app')
@section('title_for_layout', 'Recharge Request Management')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/recharge-request-list.css') }}" rel="stylesheet">
@endsection
@section('bread')
{{ Breadcrumbs::render('recharge_request_management')}}
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row py-2">
                    <div class="col-md-6">
                        <div class="heading">
                            <h2>List Recharge Request</h2>
                        </div>
                    </div>
                </div>
                <div class="row mb-2 tool-search">
                    <div class="col-7 col-lg-9 filter-wrapper">
                        <div class="row filter-body">
                            <div class="filter-field">
                                <input type="text" style="height: 37.4px"  class="form-control" id="filter-name" placeholder="Seach...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive custom-table">
                    <table id="datatableRecharge" class="table table-striped table-bordered display" style="width:100%">
                        <thead>
                            <tr>
                                <th width="6%">No</th>
                                <th>Username</th>
                                <th>Coin</th>
                                <th>Recharge Code</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editInterets" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" id="submitForm">
    </div>
</div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/js/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('assets/js/sweetalert2/sweet-alert.init.js')}}"></script>
    <script src="{{ asset('assets/js/krunk.js')}}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#datatableRecharge').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                order: [[ 0, 'desc' ]],
                ajax: {
                    url: '{{ route('recharges.datatable') }}',
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
                        data: 'user_name',
                        name: 'user_name',
                        className:'text-center align-middle'
                    },
                    {
                        data: 'coin',
                        name: 'coin',
                        className:'text-center align-middle'
                    },
                    {
                        data: 'recharge_code',
                        name: 'recharge_code',
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

            // Accept
            $('body').on('click', '.btn-accept', function (e) {
                e.preventDefault();
                var me = $(this),
                    url = me.attr('href'),
                    id =  me.attr('data-id'),
                    csrf_token = $('meta[name="csrf-token"]').attr('content');
                swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to accpet this request ?',
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
                                '_method' : 'POST',
                                '_token' : csrf_token,
                            },
                            dataType: 'json',
                            success: function (data) {
                                if(data.success == true){
                                    table.draw();
                                    toastr.success(data.message);
                                }
                            },
                            error: function(xhr){
                                Swal.fire({
                                    type: 'info',
                                    title: '',
                                    text: 'Accetp Fail',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    }
                });
            })

            // // Accept
            // $('body').on('click', '.btn-reject', function (e) {
            //     e.preventDefault();
            //     console.log($('meta[name="csrf-token"]').attr('content'));
            //     var me = $(this),
            //         url = me.attr('href'),
            //         id =  me.attr('data-id'),
            //         csrf_token = $('meta[name="csrf-token"]').attr('content');
            //     swal.fire({
            //         title: 'Are you sure?',
            //         text: 'Do you want to reject this request ?',
            //         showCancelButton: true,
            //         confirmButtonText: 'Yes',
            //         cancelButtonText: 'No',
            //         confirmButtonColor: "#DD6B55",
            //     }).then((result) => {
            //         if (result.value) {
            //             $.ajax({
            //                 url: url,
            //                 type: 'POST',
            //                 data: {
            //                     'id':id,
            //                     '_method' : 'POST',
            //                     '_token' : csrf_token,
            //                 },
            //                 dataType: 'json',
            //                 success: function (data) {
            //                     if(data.success == true){
            //                         filter()
            //                         toastr.success(data.message);
            //                     }
            //                 },
            //                 error: function(xhr){
            //                     Swal.fire({
            //                         type: 'info',
            //                         title: '',
            //                         text: 'Reject Fail',
            //                         showConfirmButton: false,
            //                         timer: 1500
            //                     });
            //                 }
            //             });
            //         }
            //     });
            // })
            
        });
    </script>
@endpush
