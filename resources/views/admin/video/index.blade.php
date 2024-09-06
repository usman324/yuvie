@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
    @include('admin.layout.partials.datatable_style')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: lightgreen;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px lightgreen;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">{{ $title }}</h1>
            <div class="sorting1__variants">
                <div class="sorting1__text ">Company:</div>
                {{-- <select class="sorting1__select" style="margin-left: 10px;" onchange="getVideo(event)">
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
                <select name="company_id" id="company_id" class="form-control select2"
                    onchange="getCompanyUser(event,'{{ url('admin/get-company-user') }}')">
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
                <div class="sorting1__text pl-3">User:</div>
                <select name="user_id" id="user_id" class="form-control select2" >
                    <option value="">Select User </option>
                    @foreach ($users as $item)
                        @if (request()->user)
                            <option value="{{ $item->id }}" @if (request()->user == $item->id) selected @endif>
                                {{ $item->first_name . ' ' . $item->last_name }}</option>
                        @else
                            <option value="{{ $item->id }}">
                                {{ $item->first_name . ' ' . $item->last_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="sorting1__options">

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
                                    <th>Creator</th>
                                    <th>Video</th>
                                    <th>Hashtags</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                ?>
                                {{-- @foreach ($records as $item)
                            @if ($item->user->getRoleNames()->first() == 'Mobile User' || $item->user->getRoleNames()->first() == 'Manager')
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $item->user?->first_name . ' ' . $item->user?->last_name }}</td>
                                    <td>
                                        <video width="150" height="100" controls>
                                            <source src="{{ $video_url . '/' . $item->video }}" type="video/mp4">
                                        </video>
                                    </td>
                                    <td>
                                        {{ str_replace('@', '#', $item->title) }}
                                    </td>
                                    <td>
                                        <label class='switch'>
                                            <input type='checkbox' value='{{ $item->status }}'
                                                @if ($item->status == 'approve') checked @endif
                                                onchange="videoApproved(event,'{{ url('admin/video_approved/' . $item->id) }}')"><span
                                                class='slider round'></span></label>
                                    </td>
                                   
                                    <td>
                                        <a href='{{ $url . '/' . $item->id . '/edit' }}' class='toggle'
                                            data-target='editClass'><svg class="icon icon-arrow-prev">
                                                <use xlink:href="{{ asset('theme/img/sprite.svg#icon-edit') }}"></use>
                                            </svg></a>
                                        <a href='javascript:' onclick="deleteRecordAjax('{{ $url . '/' . $item->id }}')"
                                            class='toggle' data-target='editClass'><svg class="icon icon-arrow-prev">
                                                <use xlink:href="{{ asset('theme/img/sprite.svg#icon-trash') }}"></use>
                                            </svg></a>
                                    </td>
                                </tr>

                                <?php
                                $i++;
                                ?>
                            @endif
                        @endforeach --}}


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
                        data.user = $("#user_id").val();
                    },
                },
                columns: [{
                    data: 'id'
                }, {
                    data: 'user'
                }, {
                    data: 'video'
                }, {
                    data: 'title'
                }, {
                    data: 'status'
                }, {
                    data: 'actions'
                }],
                buttons: datatable_buttons,
                ...datatable_setting
            });
            // myTable.columns.adjust().draw()
        });
        $('#company_id,#user_id')
            .change(function() {
                myTable.draw();
            });

        var urlParams = new URLSearchParams(window.location.search);
        // function getVideo(e) {
        //     let company = e.target.value;
        //     window.location.href = "{{ url('admin/videos') }}" + data
        // }

        // function getUser(e) {
        //     let user = e.target.value;
        //     window.location.href = "{{ url('admin/videos?user=') }}" + user
        // }
        function getCompanyUser(e, url) {
            let company_id = e.target.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: "post",
                data: {
                    company_id: company_id,
                },
                success: function(response) {
                    $("#user_id").html();
                    $("#user_id").html(response);
                },
            });
        }

        function getVideo(e) {
            let company = e.target.value;
            // let user = urlParams.get('user') ? urlParams.get('user') : '' ;
            window.location.href = "{{ url('admin/videos?company=') }}" + company + "&user=";
        }

        function getUser(e) {
            let user = e.target.value;
            let company = urlParams.get('company') ? urlParams.get('company') : '';
            window.location.href = "{{ url('admin/videos?company=') }}" + company + "&user=" +
                user;
        }
    </script>
@stop
