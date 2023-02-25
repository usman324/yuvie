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
            <h1 class="sorting1__title title ml-2">Company Create</h1>
        </div>
    </div>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary ">
                    <div class="card-content">
                        <div class="px-3">
                            <ul class="nav nav-tabs " role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active " data-toggle="tab" href="#product" role="tab">Company</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#branding" role="tab">Branding
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#videos" role="tab">Videos
                                    </a>
                                </li>
                            </ul>
                            <form id="add-company" enctype="multipart/form-data">

                                <div class="tab-content mt-4">
                                    <div class="tab-pane active " id="product" role="tabpanel">
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Company Name</label>
                                                    <input type="text" name="name" class="form-control "
                                                        placeholder="Company Name" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">First Name</label>
                                                    <input type="text" name="first_name" class="form-control "
                                                        placeholder="First Name" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Last Name</label>
                                                    <input type="text" name="last_name" class="form-control "
                                                        placeholder="Last Name" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" name="city_name" class="form-control "
                                                        placeholder="City Name" required>
                                                    {{-- <select name="city_id" id="cityDetail" class="form-control select2">
                                                        <option value="" selected>--- first select state --- </option>
                                                    </select> --}}

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <select name="state_id" {{-- onchange="getCities(event,'{{ url('admin/get-cities') }}')" --}}
                                                        class="form-control select2" required>
                                                        <option value="" selected>--- select state ---</option>
                                                        @foreach ($states as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Zip</label>
                                                    <input type="text" name="zip" class="form-control "
                                                        placeholder="Zip" required>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Email</label>
                                                    <input type="email" name="email" class="form-control "
                                                        placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Password</label>
                                                    <input type="password" name="password" class="form-control "
                                                        placeholder="Password" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Confirm Password</label>
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control " placeholder="Confirm Password" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="short_description">Description</label>
                                                    <textarea name="description" class="form-control" id="" cols="25" rows="5"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card mb-4">
                                                    <div class="card-header">
                                                        <strong>Default Information</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_location_state">Location if
                                                                    different to
                                                                    company</label>
                                                                <select class="form-control" id="company_location_state"
                                                                    name="company_location_state select2">
                                                                    <option value="">Select</option>
                                                                    <option value="Alabama">Alabama</option>
                                                                    <option value="Wyoming">Wyoming</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_location_title">Title</label>
                                                                <input type="text" class="form-control"
                                                                    id="company_location_title"
                                                                    name="company_location_title" placeholder="Title">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_location_event">Event</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="company_location_event"
                                                                    name="company_location_event" placeholder="Event">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_group">Group</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="company_group" name="company_group"
                                                                    placeholder="Group">
                                                            </div>

                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted" for="latitude">Latitude</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="latitude" name="latitude"
                                                                    placeholder="Latitude">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="longitude">Longitude</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="longitude" name="longitude"
                                                                    placeholder="Longitude">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card mb-4">
                                                    <div class="card-header">
                                                        <strong>Landing Page Main CTA</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_website_url">Website
                                                                    URL</label>
                                                                <input type="text" class="form-control"
                                                                    id="company_website_url" name="company_website_url"
                                                                    placeholder="Website URL">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_destination_url">Destination URL</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="company_destination_url"
                                                                    name="company_destination_url"
                                                                    placeholder="Destination URL">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted" for="company_button_text">Button
                                                                    Text</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="company_button_text" name="company_button_text"
                                                                    placeholder="Button Text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card mb-4">
                                                    <div class="card-header">
                                                        <strong>FTP Details</strong>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_ftp_protocol">Protocol</label>
                                                                <select class="form-control select2"
                                                                    id="company_ftp_protocol" name="company_ftp_protocol">
                                                                    <option value="FTP">FTP</option>
                                                                    <option value="SFTP">SFTP</option>
                                                                    <option value="API">API</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted host_field"
                                                                    for="company_ftp_host">Host</label>
                                                                <input type="text" class="form-control"
                                                                    id="company_ftp_host" name="company_ftp_host"
                                                                    placeholder="Host">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_ftp_username">Username</label>
                                                                <input type="text" class="form-control"
                                                                    id="company_ftp_username" name="company_ftp_username"
                                                                    placeholder="Username">
                                                            </div>

                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_ftp_password">Password</label>
                                                                <input type="password" class="form-control"
                                                                    id="company_ftp_password" name="company_ftp_password"
                                                                    placeholder="Password">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted default_diractory"
                                                                    for="company_ftp_directory">Default Directory</label>
                                                                <input type="text" class="form-control"
                                                                    id="company_ftp_directory"
                                                                    name="company_ftp_directory"
                                                                    placeholder="FTP Directory">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="branding" role="tabpanel">
                                        <div class="row mt-2">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Profile Logo <small>(JPG or PNG 256 x
                                                            128)</small>
                                                    </label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="profile_logo" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Social Media Logo: Small <small>(JPG or PNG 256 x
                                                            128)</small></label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="social_media_logo_small" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="title">Social Media Logo: Large <small>(JPG or PNG 256 x
                                                            128)</small></label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="social_media_logo_large" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Background Music <small>(mp3)</small> </label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="background_music" required>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="title">Video Watermark</label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="video_watermark" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="videos" role="tabpanel">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" name="title" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Video Type</label>
                                                    <select name="type" class="form-control">
                                                        <option value="">select type </option>
                                                        <option value="landscape">Landscape</option>
                                                        <option value="portrait">Portrait</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">Video
                                                        <small>(MP4 1280 x 720)</small>
                                                    </label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="video" required>
                                                </div>
                                            </div>
                                            {{-- <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Thumbnail image <small>(JPG or PNG
                                                            1280 x 720)</small></label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        data-default-file="{{ $video_url . '/' . $record->thumbnail_image }}"
                                                        name="thumbnail_image" required>
                                                </div>
                                            </div> --}}

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="short_description">Description</label>
                                                    <textarea name="video_description" class="form-control" id="" cols="25" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="login__field field">
                                    <button type="button"
                                        onclick="addFormData(event,'post','{{ url('admin/companies') }}','{{ url('admin/companies') }}','add-company')"
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
