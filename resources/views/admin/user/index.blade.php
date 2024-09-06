@extends('admin.layout.master')
@section('style')

    <title>{{ 'YuVie-Business:' . $title }}</title>
    @include('admin.layout.partials.datatable_style')

    <style>
        /* .products__cell:nth-child(2) {
                                        -webkit-box-flex: 1;
                                        -ms-flex-positive: 1;
                                        flex-grow: 0.1 !important;
                                        padding: 0 20px;
                                        text-align: left;
                                    }

                                    .products__cell:nth-child(4),
                                    .products__cell:nth-child(5),
                                    .products__cell:nth-child(7) {
                                        width: 200px !important;
                                        padding-right: 72px;
                                    }

                                    .products__cell {
                                        text-align: center !important;
                                        color: #44444F;
                                    } */
    </style>
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">{{ $title }}</h1>
            <div class="sorting1__variants">
                <div class="sorting1__text">Company:</div>
                {{-- <select class="sorting1__select" style="margin-left: 10px;" onchange="getUser(event)">
                    <option value="">Select company</option>
                    @foreach ($companies as $item)
                        @if (request()->company)
                            <option value="{{ $item->id }}" @if (request()->company == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @else
                            <option value="{{ $item->id }}" @if ($company?->id == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @endif
                    @endforeach
                </select> --}}
                <select name="company_id" id="company_id" class="form-control select2" >
                    <option value="">Select Company </option>
                    @foreach ($companies as $item)
                        @if (request()->company)
                            <option value="{{ $item->id }}" @if (request()->company == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @else
                            <option value="{{ $item->id }}" @if ($company?->id == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="sorting1__options">
                {{-- <div class="dropdown js-dropdown"><a class="dropdown__head js-dropdown-head" href="#">
                        <div class="dropdown__text">Sort by:</div>
                        <div class="dropdown__category">Default</div>
                    </a>
                    <div class="dropdown__body js-dropdown-body">
                        <label class="checkbox checkbox_sm checkbox_green">
                            <input class="checkbox__input" type="checkbox" />
                            <span class="checkbox__in"><span class="checkbox__tick"></span><span
                                    class="checkbox__text">Project
                                    Name</span></span></label><label class="checkbox checkbox_sm checkbox_green"><input
                                class="checkbox__input" type="checkbox" checked="checked" /><span class="checkbox__in"><span
                                    class="checkbox__tick"></span><span class="checkbox__text">Newest
                                    Project</span></span></label><label class="checkbox checkbox_sm checkbox_green"><input
                                class="checkbox__input" type="checkbox" checked="checked" /><span class="checkbox__in"><span
                                    class="checkbox__tick"></span><span class="checkbox__text">Due
                                    Date</span></span></label><label class="checkbox checkbox_sm checkbox_green"><input
                                class="checkbox__input" type="checkbox" /><span class="checkbox__in"><span
                                    class="checkbox__tick"></span><span class="checkbox__text">Project
                                    Type</span></span></label>
                    </div>
                </div>
                <a class="sorting1__filters" href="#">
                    <svg class="icon icon-filters">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-filters') }}"></use>
                    </svg>
                </a> --}}
                <?php
                $id = request()->company ? request()->company : $company?->id;
                ?>
                <a href="{{ $url . '/create?q=' . $id }}" class="sorting1__btn btn rounded-pill text-white"
                    style="background-color:#ff5926 "><svg class="icon icon-plus">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-plus') }}"></use>
                    </svg>
                    <span class="btn__text">New User</span>
                </a>
            </div>
        </div>
    </div>
    {{-- <div class="products"> --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="myTable" class="table rounded table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#Id</th>
                                    <th>Image</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
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
    {{-- </div> --}}
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
                    data: 'image'
                }, {
                    data: 'first_name'
                }, {
                    data: 'last_name'
                }, {
                    data: 'email'
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
        // $('#min_amount,#max_amount,#km_in').on('keyup', function() {
        //     myTable.draw();
        // });

        function getUser(e) {
            let company = e.target.value;
            window.location.href = "{{ url('admin/users?company=') }}" + company
        }
    </script>
@stop
