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
            <h1 class="sorting1__title title ml-2">Add Watermark</h1>
        </div>
    </div>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary ">
                    <div class="card-content">
                        <div class="px-3">
                            <form id="add-video" enctype="multipart/form-data">
                                <div class="tab-pane active" id="videos" role="tabpanel">

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="title">Comapny
                                                </label>
                                                <select name="company_id" class="form-control select2">
                                                    <option value="">select company </option>
                                                    @foreach ($companies as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (request()->q == $item->id) selected @endif>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    
                                        {{-- <div class="col-4">
                                            <div class="form-group">
                                                <label for="title">Name
                                                </label>
                                                <input class="field__input" required type="text" name="name"
                                                    placeholder="Name">
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row mt-2">

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="title">Main Logo</label>
                                                <input type="file" class="dropify form-control " data-height="100"
                                                    name="video_watermark" required>
                                            </div>
                                        </div> 
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="title">Watermark</label>
                                                <input type="file" class="dropify form-control " data-height="100"
                                                    name="white_logo" required>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                                <div class="login__field field">
                                    <button type="button"
                                        onclick="addFormData(event,'post','{{ url('admin/watermarks') }}','{{ url('admin/watermarks') }}','add-video')"
                                        class="btn btn-sm rounded-pill text-white" style="background-color:#ff5926 ">Add
                                    </button>
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