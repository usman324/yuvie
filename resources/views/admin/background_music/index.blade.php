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
                {{-- <div class="sorting1__text">Company:</div> --}}
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
                {{-- <select name="company_id" id="company_id" class="form-control select2">
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
                </select> --}}
            </div>
            <div class="sorting1__options">
                <?php
                $id = request()->company ? request()->company : $company?->id;
                ?>
                {{-- <a href="{{ url('admin/background-musics/create') }}" --}}
                <a href="{{ url('admin/background-musics/create?q=' . $id) }}"
                    class="sorting1__btn btn rounded-pill text-white" style="background-color:#ff5926 "><svg
                        class="icon icon-plus">
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
                                    {{-- <th>Company</th> --}}
                                    {{-- <th>Folder</th> --}}
                                    <th>Name</th>
                                    <th>Audio</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBodyContents">
                                {{-- <?php
                                // $i = 1;
                                //
                                ?>
                        @foreach ($records as $item)
                            <tr class="tableRow" data-id="{{ $item->id }}">
                                <td>{{ $i }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <audio controls>
                                        <source src="{{ $music_url . '/' . $item->audio }}" type="audio/ogg">
                                    </audio>
                                </td>
                                <td>

                                    <a href='{{ $music_url . '/' . $item->audio }}' download class='toggle'
                                        data-target='editClass'><svg class="icon icon-arrow-prev">
                                            <use xlink:href="{{ asset('theme/img/sprite.svg#icon-download') }}"></use>
                                        </svg></a>
                                    
                                    <a href='javascript:' onclick="deleteRecordAjax('{{ $url . '/' . $item->id }}')"
                                        class='toggle' data-target='editClass'><svg class="icon icon-arrow-prev">
                                            <use xlink:href="{{ asset('theme/img/sprite.svg#icon-trash') }}"></use>
                                        </svg></a>
                                </td>
                            </tr>

                            <?php
                            $i++;
                            ?> --}}
                                {{-- @endforeach --}}


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
    <script src="{{ asset('jquery_ui.js') }}"></script>
    <script>
        // function getMusic(e) {
        //     let company = e.target.value;
        //     window.location.href = "{{ url('admin/background-musics?company=') }}" + company
        // }
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
                    data: 'audio'
                }, {
                    data: 'actions'
                }],
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
            $("#tableBodyContents").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {

                var order = [];
                var token = $('meta[name="csrf-token"]').attr('content');

                $('tr.tableRow').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('music-reorder') }}",
                    data: {
                        order: order,
                        _token: token
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            console.log(response);
                        } else {
                            console.log(response);
                        }
                    }
                });
            }
        });
    </script>
@stop
