@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
    @include('admin.layout.partials.datatable_style')
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">{{ $title . 's' }}</h1>
            <div class="sorting1__variants">
                {{-- <div class="sorting1__text">Company:</div>
                <select name="company_id" id="company_id" class="form-control select2">
                    <option value="">Select Company </option>
                    @foreach ($companies as $item)
                        <option value="{{ $item->id }}"> {{ $item->name }}</option>
                    @endforeach
                </select> --}}
            </div>
            <div class="sorting1__options">
                <?php
                // $id = request()->company ? request()->company : $company?->id;
                ?>
                <a href="{{ url('admin/fonts/create') }}" class="sorting1__btn btn rounded-pill text-white"
                    style="background-color:#ff5926 "><svg class="icon icon-plus">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-plus') }}"></use>
                    </svg>
                    <span class="btn__text">Add New</span>
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
                                    <th>Font File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBodyContents">
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
    {{-- <script src="{{ asset('jquery_ui.js') }}"></script> --}}
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
                    },
                    {
                        data: 'file_name'
                    },
                    {
                        data: 'image'
                    }, {
                        data: 'actions'
                    }
                ],
                buttons: datatable_buttons,
                createdRow: function(row, data) {
                    // console.log(data.id);
                    $(row).addClass('tableRow');
                    $(row).attr('data-id', data.id);
                    // $(row).children("td:second").addClass('bg-white');
                },
                ...datatable_setting
            });
            // $("#table").DataTable();
            $('#company_id')
                .change(function() {
                    myTable.draw();
                });
        });
    </script>
@stop
