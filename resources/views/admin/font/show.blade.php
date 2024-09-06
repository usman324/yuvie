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
            <h1 class="sorting1__title title ml-2">Background Music</h1>
        </div>
    </div>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary ">
                    <div class="card-content">
                        <div class="px-3">
                                <div class="row">
                                    <div class="col-6">
                                        <h5>Company</h5>
                                        <p>{{$record->company->name}}</p>
                                    </div>
                                    <div class="col-6">
                                        <h5>Name</h5>
                                        <p>{{$record->name}}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    @foreach ($record->images as $item)
                                        <div class="col-4">
                                            <audio controls>
                                                <source src="{{ $music_url . '/' . $item->image }}" type="audio/ogg">
                                            </audio>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>

                </div>
                <!-- /.card -->
            </div>
        </div>
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
