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
                <div class="sorting1__text">Company:</div>
                {{-- <select class="sorting1__select" style="margin-left: 10px;" onchange="getMusic(event)">
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

                <select name="company_id" id="company_id" class="form-control select2">
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
                <?php
                $id = request()->company ? request()->company : $company?->id;
                ?>
                <a href="{{ url('admin/watermarks/create?q=' . $id) }}" class="sorting1__btn btn rounded-pill text-white"
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
                                    <th>Company</th>
                                    <th>Logos</th>
                                    <!--<th>White Logos</th>-->
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
                    data: 'company'
                }, {
                    data: 'video_watermark'
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

        function getMusic(e) {
            let company = e.target.value;
            window.location.href = "{{ url('admin/watermarks?company=') }}" + company
        }
    </script>
@stop
