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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
@stop
@section('content')
    <div class="sorting1">
        <div class="sorting1__row">
            <h1 class="sorting1__title title ml-2">Background Music Create</h1>
        </div>
    </div>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary ">
                    <div class="card-content">
                        <div class="px-3">
                            <div class="tab-pane active" id="videos" role="tabpanel">
                                <form id="add-video" enctype="multipart/form-data">
                                    <input type="hidden" name="images" id="backgroudMusic">
                                    <div class="row">
                                        {{-- <input type="hidden" name="company_id" value="{{ request()->q }}"> --}}
                                        {{-- <div class="col-6">
                                            <div class="form-group">
                                                <label for="title">Comapny
                                                </label>
                                                <select name="company_id" class="form-control select2">
                                                    <option value="">select company </option>
                                                    @foreach ($companies as $item)
                                                        <option value="{{ $item->id }}"
                                                            @if (request()->q == $item->id) selected @endif
                                                            >
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-4">
                                            <div class="form-group">
                                                <label for="title">Folder
                                                </label>
                                                <select name="file_manager_id" class="form-control select2">
                                                    <option value="">select folder </option>
                                                    @foreach ($file_managers as $file_manager)
                                                        <option value="{{ $file_manager->id }}">
                                                            {{ $file_manager->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-6">
                                            <div class="form-group">
                                                <label for="title">Name
                                                </label>
                                                <input class="field__input" required type="text" name="name"
                                                    placeholder="Name">
                                            </div>
                                        </div> --}}
                                    </div>
                                </form>

                                <div class="row mt-2">

                                    <div class="col-12">
                                        {{-- <div class="form-group"> --}}
                                        <label for="title">Audio
                                            <small>(Mp3)</small>
                                        </label>
                                        {{-- <input type="file" class="dropify form-control " data-height="100"
                                                    name="audio" required multiple> --}}
                                        <form class="dropzone dropzone-primary" id="dropzone"
                                            action="{{ url('admin/background-multiple') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="dz-message needsclick">
                                                <i class="icon-cloud-up"></i>
                                                <h6>Drop files here or click to upload files.</h6>
                                            </div>
                                        </form>
                                        {{-- </div> --}}
                                    </div>


                                </div>

                            </div>

                            <div class="login__field field m-2">
                                <button type="button"
                                    onclick="addFormData(event,'post','{{ url('admin/background-musics') }}','{{ request()->q ? url('admin/companies/' . request()->q . '/edit') : url('admin/background-musics') }}','add-video')"
                                    class="btn btn-sm rounded-pill text-white" style="background-color:#ff5926 ">Add
                                </button>
                                <a href="{{ $url }}" class="btn btn-sm  rounded-pill border-info" style=""
                                    type="submit">Cancel
                                </a>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script>
        var myDropzone = Dropzone.options.dropzone = {
            maxFiles: 10,
            // maxFilesize: 10, 
            // acceptedFiles: 'audio/mp3, audio/wav',
            init: function() {
                this.on("complete", function(file) {
                    var response = JSON.parse(file.xhr.response);
                    if (response.message === 'File Upload') {
                        $('#backgroudMusic').val($('#backgroudMusic').val() + ',' + response.record.id)
                    }
                    // }
                });
                this.on('error', function(file, errorMessage) {
                    error = errorMessage.errors.file[0];
                    showWarn(error)
                    $(file.previewElement).remove();

                });
            }
        };
    </script>
@stop
