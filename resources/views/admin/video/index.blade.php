@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title">{{ $title }} List</h1>
            <div class="sorting1__variants">
                <div class="sorting1__text">Show:</div><select class="sorting1__select">
                    <option selected>All {{ $title }}</option>
                    <option>All {{ $title }}</option>
                </select>
            </div>
            <div class="sorting1__options">
                <div class="dropdown js-dropdown"><a class="dropdown__head js-dropdown-head" href="#">
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
                </a>
                {{-- <a href="{{ $url . '/create' }}" class="sorting1__btn btn rounded-pill text-white"
                    style="background-color:#ff5926 "><svg class="icon icon-plus">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-plus') }}"></use>
                    </svg>
                    <span class="btn__text">New Video</span>
                </a> --}}
            </div>
        </div>
    </div>
    <div class="products">
        <div class="products__container">
            <div class="products__body">
                <table id="myTable" class="table rounded table-bordered table-striped">
                    <thead>
                        <tr>
                            <th >#Id</th>
                            <th >Company</th>
                            <th>Video</th>
                            <th>Title</th>
                            {{-- <th>Description</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($records as $item)
                            @if ($item->user->getRoleNames()->first() == 'Mobile User')
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $item->company?->name }}</td>
                                    <td>
                                        <video width="150" height="100" controls>
                                            <source src="{{ $video_url . '/' . $item->video }}" type="video/mp4">
                                        </video>
                                    </td>
                                    <td>
                                        {{ $item->title }}
                                    </td>
                                    {{-- <td>
                                        {{ $item->description }}
                                    </td> --}}
                                    {{-- <td><img style="width:250px; height:80px;" class="header7__pic header7__pic_white w-25"
                                            src="{{ $video_url . '/' . $item->thumbnail_image }}" alt="">
                                    </td> --}}
                                    <td>
                                        <a href='{{ $url . '/' . $item->id . '/edit' }}' class='toggle'
                                            data-target='editClass'><svg class="icon icon-arrow-prev">
                                                <use xlink:href="{{ asset('theme/img/sprite.svg#icon-edit') }}"></use>
                                            </svg></a>
                                        <a href='javascript:' onclick='deleteRecordAjax("{{ $url . '/' . $item->id }}")'
                                            class='toggle' data-target='editClass'><svg class="icon icon-arrow-prev">
                                                <use xlink:href="{{ asset('theme/img/sprite.svg#icon-trash') }}"></use>
                                            </svg></a>
                                    </td>
                                </tr>

                                <?php
                                $i++;
                                ?>
                            @endif
                        @endforeach


                    </tbody>
                </table>

            </div>
        </div>
    </div>

@stop
@section('script')
@stop
