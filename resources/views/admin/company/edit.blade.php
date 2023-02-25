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
            <h1 class="sorting1__title title ml-2">Company Update</h1>
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
                                                    <input type="text" name="name" value="{{ $record->name }}"
                                                        class="form-control " placeholder="Company Name" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">First Name</label>
                                                    <input type="text" name="first_name"
                                                        value="{{ $record->first_name }}" class="form-control "
                                                        placeholder="First Name" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Last Name</label>
                                                    <input type="text" name="last_name" value="{{ $record->last_name }}"
                                                        class="form-control " placeholder="Last Name" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" name="city_name" class="form-control " value="{{ $record->city_name }}"
                                                        placeholder="City Name" required>
                                                        {{-- <select name="city_id" id="cityDetail" class="form-control select2">
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}"
                                                                    @if ($city->id == $record->city_id) selected @endif>
                                                                    {{ $city->name }}</option>
                                                            @endforeach
                                                        </select> --}}

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <select name="state_id"
                                                        onchange="getCities(event,'{{ url('admin/get-cities') }}')"
                                                        class="form-control select2" required>
                                                        <option value="" selected>--- select state ---</option>
                                                        @foreach ($states as $item)
                                                            <option value="{{ $item->id }}"
                                                                @if ($item->id == $record->state_id) selected @endif>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Zip</label>
                                                    <input type="text" name="zip" value="{{ $record->zip }}"
                                                        class="form-control " placeholder="Zip" required>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Email</label>
                                                    <input type="email" name="email" value="{{ $record->email }}"
                                                        class="form-control " placeholder="Email" required>
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
                                                    <textarea name="description" class="form-control" id="" cols="25" rows="5">{{ $record->description }}</textarea>
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
                                                                    <option value="Alabama"
                                                                        @if ($record?->companyDetail->company_location_state == 'Alabama') selected @endif>
                                                                        Alabama</option>
                                                                    <option value="Wyoming"
                                                                        @if ($record?->companyDetail->company_location_state == 'Wyoming') selected @endif>
                                                                        Wyoming</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_location_title">Title</label>
                                                                <input type="text" class="form-control"
                                                                    id="company_location_title"
                                                                    value="{{ $record?->companyDetail->company_location_title }}"
                                                                    name="company_location_title" placeholder="Title">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_location_event">Event</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="company_location_event"
                                                                    value="{{ $record?->companyDetail->company_location_event }}"
                                                                    name="company_location_event" placeholder="Event">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_group">Group</label>
                                                                <input type="text" required=""
                                                                    value="{{ $record?->companyDetail->company_group }}"
                                                                    class="form-control" id="company_group"
                                                                    name="company_group" placeholder="Group">
                                                            </div>

                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted" for="latitude">Latitude</label>
                                                                <input type="text" required=""
                                                                    value="{{ $record?->companyDetail->latitude }}"
                                                                    class="form-control" id="latitude" name="latitude"
                                                                    placeholder="Latitude">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="longitude">Longitude</label>
                                                                <input type="text" required=""
                                                                    value="{{ $record?->companyDetail->longitude }}"
                                                                    class="form-control" id="longitude" name="longitude"
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
                                                                    id="company_website_url"
                                                                    value="{{ $record->companyDetail->company_website_url }}"
                                                                    name="company_website_url" placeholder="Website URL">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_destination_url">Destination URL</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="company_destination_url"
                                                                    value="{{ $record?->companyDetail->company_destination_url }}"
                                                                    name="company_destination_url"
                                                                    placeholder="Destination URL">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted" for="company_button_text">Button
                                                                    Text</label>
                                                                <input type="text" required="" class="form-control"
                                                                    id="company_button_text"
                                                                    value="{{ $record?->companyDetail->company_button_text }}"
                                                                    name="company_button_text" placeholder="Button Text">
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
                                                                    <option value="FTP"
                                                                        @if ($record?->companyDetail->company_ftp_protocol == 'FTP') selected @endif>
                                                                        FTP</option>
                                                                    <option value="SFTP"
                                                                        @if ($record?->companyDetail->company_ftp_protocol == 'SFTP') selected @endif>
                                                                        SFTP</option>
                                                                    <option value="API"
                                                                        @if ($record?->companyDetail->company_ftp_protocol == 'API') selected @endif>
                                                                        API</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted host_field"
                                                                    for="company_ftp_host">Host</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $record?->companyDetail->company_ftp_host }}"
                                                                    id="company_ftp_host" name="company_ftp_host"
                                                                    placeholder="Host">
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                                <label class="text-muted"
                                                                    for="company_ftp_username">Username</label>
                                                                <input type="text" class="form-control"
                                                                    id="company_ftp_username"
                                                                    value="{{ $record?->companyDetail->company_ftp_username }}"
                                                                    name="company_ftp_username" placeholder="Username">
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
                                                                    value="{{ $record?->companyDetail->company_ftp_directory }}"
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
                                                        data-default-file="{{ $image_url . '/' . $record?->companyBranding->profile_logo }}"
                                                        name="profile_logo" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Social Media Logo: Small <small>(JPG or PNG 256 x
                                                            128)</small></label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        data-default-file="{{ $image_url . '/' . $record?->companyBranding->social_media_logo_small }}"
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
                                                        data-default-file="{{ $image_url . '/' . $record?->companyBranding->social_media_logo_large }}"
                                                        name="social_media_logo_large" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Background Music <small>(mp3)</small> </label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        data-default-file="{{ $image_url . '/' . $record?->companyBranding->background_music }}"
                                                        name="background_music" required>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="title">Video Watermark</label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        data-default-file="{{ $image_url . '/' . $record?->companyBranding->video_watermark }}"
                                                        name="video_watermark" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="videos" role="tabpanel">
                                        <div class="row mt-2">
                                            <table id="myTable" class="table rounded table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#Id</th>
                                                        <th>Company</th>
                                                        <th>Video</th>
                                                        <th>Title</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    ?>

                                                    @if (!$record->videos->isEmpty())
                                                        @foreach ($record->videos as $item)
                                                            @if ($item->user->getRoleNames()->first() != 'Mobile User')
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $item->company?->name }}</td>
                                                                    <td>
                                                                        <video width="150" height="100" controls>
                                                                            <source
                                                                                src="{{ $video_url . '/' . $item->video }}"
                                                                                type="video/mp4">
                                                                        </video>
                                                                    </td>
                                                                    <td>
                                                                        {{ $item->title }}
                                                                    </td>
                                                                    <td>
                                                                        <a href='{{ url('admin/videos/' . $item->id . '/edit') }}'
                                                                            class='toggle' data-target='editClass'><svg
                                                                                class="icon icon-arrow-prev">
                                                                                <use
                                                                                    xlink:href="{{ asset('theme/img/sprite.svg#icon-edit') }}">
                                                                                </use>
                                                                            </svg></a>
                                                                        <a href='javascript:'
                                                                            onclick="deleteRecordAjax('{{ url('admin/videos' . $item->id) }}')"
                                                                            class='toggle' data-target='editClass'><svg
                                                                                class="icon icon-arrow-prev">
                                                                                <use
                                                                                    xlink:href="{{ asset('theme/img/sprite.svg#icon-trash') }}">
                                                                                </use>
                                                                            </svg></a>
                                                                    </td>
                                                                </tr>

                                                                <?php
                                                                $i++;
                                                                ?>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    @endif


                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>

                                <div class="login__field field">
                                    <button type="button"
                                        onclick="addFormData(event,'post','{{ url('admin/companies/' . $record->id) }}','{{ url('admin/companies') }}','add-company')"
                                        class="btn btn-sm rounded-pill text-white"
                                        style="background-color:#ff5926 ">Update
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
