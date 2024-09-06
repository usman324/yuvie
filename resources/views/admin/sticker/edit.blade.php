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
            <h1 class="sorting1__title title ml-2">Sticker Update</h1>
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
                                    <div class="row">
                                        <input type="hidden" name="company_id" value="{{ $record->company_id }}">
                                        {{-- <div class="col-6">
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

                                        </div> --}}
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Image
                                                </label>
                                                <input type="file" class="dropify form-control " data-height="100"
                                                    data-default-file="{{ $music_url . '/' . $record->image }}"
                                                    name="image">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="login__field field m-2">

                                <button type="button"
                                    onclick="addFormData(event,'post','{{ url('admin/stickers/' . $record->id) }}','{{ $record->company_id ? url('admin/companies/' . $record->company_id . '/edit') : url('admin/stickers') }}','add-video')"
                                    class="btn btn-sm rounded-pill text-white" style="background-color:#ff5926 ">Update
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

@stop
