@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> --}}
    <style>
        body .dark .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link .active {
            color: rgb(19, 18, 18);
            background-color: white
        }
    </style>
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title ml-2">Video Update</h1>
        </div>
    </div>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary ">
                    <div class="card-content">
                        <div class="px-3">
                            <form id="add-video" enctype="multipart/form-data">
                                {{-- @method('Put') --}}
                                <div class="tab-pane active" id="videos" role="tabpanel">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="title">Comapny
                                                </label>
                                                <select name="company_id" class="form-control select2">
                                                    <option value="">select company </option>
                                                    @foreach ($companies as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if ($item->id == $record->company_id) selected @endif>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="title">Type
                                                </label>
                                                <select name="type" class="form-control select2">
                                                    <option value="">select type </option>
                                                    <option value="landscape"
                                                        @if ($record->type == 'landscape') selected @endif>Landscape</option>
                                                    <option value="portrait"
                                                        @if ($record->type == 'portrait') selected @endif>Portrait</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-4">
                                            <div class="form-group">
                                                <label for="title">Hashtags</label>
                                                <input type="text" class=" form-control " name="title"
                                                    value="{{ $record->title }}" required>
                                            </div>
                                        </div> --}}
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="title">Alpha</label><br>
                                                <label class="checkbox checkbox_green checkbox_big">
                                                    <input class="checkbox__input" type="checkbox"
                                                        @if ($record->alpha != 0) checked @endif  name="alpha">
                                                    <span class="checkbox__in"><span
                                                            class="checkbox__tick"></span></span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">

                                        {{-- <div class="col-6">
                                            <div class="form-group">
                                                <label for="title"> Video
                                                    <small>(MP4 1080 x 1920)</small>
                                                </label>
                                                <input type="file" class="dropify form-control " data-height="100"
                                                    data-default-file="{{ $video_url . '/' . $record->video }}"
                                                    name="video" required>
                                            </div>
                                        </div> --}}
                                        <!--<div class="col-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label for="title">Thumbnail image <small>(JPG or PNG 300x300-->
                                        <!--                )</small></label>-->
                                        <!--        <input type="file" class="dropify form-control " data-height="100"-->
                                        <!--            data-default-file="{{ $video_url . '/' . $record->thumbnail_image }}"-->
                                        <!--            name="thumbnail_image" required>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="title">Intro Video
                                                    <small>(MP4 1080 x 1920)</small>
                                                </label>
                                                <input type="file" class="dropify form-control " data-height="100"
                                                    data-default-file="{{ $video_url . '/' . $record->intro_video }}"
                                                    name="intro_video" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="title">Outro Video
                                                    <small>(MP4 1080 x 1920)</small>
                                                </label>
                                                <input type="file" class="dropify form-control " data-height="100"
                                                    data-default-file="{{ $video_url . '/' . $record->outer_video }}"
                                                    name="outer_video" required>
                                            </div>
                                        </div>


                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="short_description">Description</label>
                                                <textarea name="description" class="form-control" id="" cols="25" rows="5">{{ $record->description }}</textarea>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="login__field field">
                                    @if (request()->q)
                                        <button type="button"
                                            onclick="addFormData(event,'post','{{ url('admin/videos/' . $record->id) }}','{{ url('admin/companies/' . $record->company_id . '/edit') }}','add-video')"
                                            class="btn btn-sm rounded-pill text-white"
                                            style="background-color:#ff5926 ">Update
                                        </button>
                                    @else
                                        <button type="button"
                                            onclick="addFormData(event,'post','{{ url('admin/videos/' . $record->id) }}','{{ url('admin/videos') }}','add-video')"
                                            class="btn btn-sm rounded-pill text-white"
                                            style="background-color:#ff5926 ">Update
                                        </button>
                                    @endif

                                    <a href="{{ $url }}" class="btn btn-sm  rounded-pill border-info"
                                        style="" type="submit">Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div>
@stop
@section('script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script> --}}
@stop
