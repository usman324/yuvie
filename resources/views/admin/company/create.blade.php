@extends('admin.layout.master')
@section('style')
    <title>{{ 'YuVie-Business:' . $title }}</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> --}}

@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title ml-2">Company Create</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-content">
                        <div class="px-3">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#product" role="tab">Company</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#product_structure" role="tab">Videos
                                    </a>
                                </li>
                            </ul>
                            <form action="{{ $url }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content mt-4">
                                    <div class="tab-pane active " id="product" role="tabpanel">
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Company Name</label>
                                                    <input type="text" name="title" class="form-control "
                                                        placeholder="Company Name" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">First Name</label>
                                                    <input type="text" name="title" class="form-control "
                                                        placeholder="First Name" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Last Name</label>
                                                    <input type="text" name="title" class="form-control "
                                                        placeholder="Last Name" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <select name="product_category_id" class="form-control select2"
                                                        required>
                                                        <option value="" selected>select city</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <select name="brand_id" class="form-control select2" required>
                                                        <option value="" selected>select state</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Zip</label>
                                                    <input type="text" name="title" class="form-control "
                                                        placeholder="Zip" required>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Email</label>
                                                    <input type="email" name="title" class="form-control "
                                                        placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Password</label>
                                                    <input type="text" name="title" class="form-control "
                                                        placeholder="Password" required>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="title">Confirm Password</label>
                                                    <input type="text" name="title" class="form-control "
                                                        placeholder="Confirm Password" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="short_description"> Description</label>
                                                    <textarea name="" class="form-control" id="" cols="25" rows="5"></textarea>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="tab-pane " id="product_structure" role="tabpanel">
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Profile Logo <small>(JPG or PNG 256 x
                                                            128)</small>
                                                    </label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="image" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Social Media Logo: Small <small>(JPG or PNG 256 x
                                                            128)</small></label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="image" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Social Media Logo: Large <small>(JPG or PNG 256 x
                                                            128)</small></label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="image" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="title">Background Music <small>(mp3)</small> </label>
                                                    <input type="file" class="dropify form-control " data-height="100"
                                                        name="image" required>
                                                </div>
                                            </div>

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
                                                            for="company_location_state">Location if different to
                                                            company</label>
                                                        <select class="form-control" required=""
                                                            id="company_location_state" name="company_location_state">
                                                            <option value="">Select</option>
                                                            <option value="Alabama">Alabama</option>
                                                            <option value="Wyoming">Wyoming</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                        <label class="text-muted"
                                                            for="company_location_title">Title</label>
                                                        <input type="text" class="form-control"
                                                            id="company_location_title" name="company_location_title"
                                                            placeholder="Title">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                        <label class="text-muted"
                                                            for="company_location_event">Event</label>
                                                        <input type="text" required="" class="form-control"
                                                            id="company_location_event" name="company_location_event"
                                                            placeholder="Event">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                        <label class="text-muted" for="company_group">Group</label>
                                                        <input type="text" required="" class="form-control"
                                                            id="company_group" name="company_group"
                                                            placeholder="Group">
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                        <label class="text-muted" for="latitude">Latitude</label>
                                                        <input type="text" required="" class="form-control"
                                                            id="latitude" name="latitude" placeholder="Latitude">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 form-group col-sm-12">
                                                        <label class="text-muted" for="longitude">Longitude</label>
                                                        <input type="text" required="" class="form-control"
                                                            id="longitude" name="longitude" placeholder="Longitude">
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
                                                        <label class="text-muted" for="company_website_url">Website
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
                                                        <select class="form-control" id="company_ftp_protocol"
                                                            name="company_ftp_protocol">
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
                                                            id="company_ftp_directory" name="company_ftp_directory"
                                                            placeholder="FTP Directory">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="login__field field">
                                    <button type="button"
                                        onclick="addFormData(event,'post','{{ url('admin/users') }}','{{ url('admin/users') }}','add-user')"
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
