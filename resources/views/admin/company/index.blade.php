@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
    @include('admin.layout.partials.datatable_style')
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">{{ $title }}</h1>
            <div class="sorting1__variants">
                <div class="sorting1__text">Company:</div><select class="sorting1__select">
                    <option selected>All {{ $title }}</option>
                    <option>All {{ $title }}</option>
                </select>
            </div>
            <div class="sorting1__options">

                <a href="{{ $url . '/create' }}" class="sorting1__btn btn rounded-pill text-white"
                    style="background-color:#ff5926 "><svg class="icon icon-plus">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-plus') }}"></use>
                    </svg>
                    <span class="btn__text">New Company</span>
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="myTable" class="table rounded table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#Id</th>
                                    <th>Name</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Action</th>
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

@stop
@section('script')
    @include('admin.layout.partials.datatable_script')
    <script>
        $(function() {
            myTable = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ $url }}',
                    dataType: "json",
                    type: "GET",
                    data: function(data) {
                        data.company = $("#company_id").val();
                    },
                },
                columns: [{
                    data: 'id'
                }, {
                    data: 'name'
                }, {
                    data: 'first_name'
                }, {
                    data: 'last_name'
                }, {
                    data: 'email'
                }, {
                    data: 'state'
                }, {
                    data: 'city_name'
                }, {
                    data: 'actions'
                }],
                buttons: datatable_buttons,
                ...datatable_setting
            });
            // myTable.columns.adjust().draw()
        });
        $('#company_id')
            .change(function() {
                myTable.draw();
            });
    </script>
@stop
