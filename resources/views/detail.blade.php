<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layout.partials.style')
    <title>{{ 'YuVie-Business: Detail' }}</title>
    <link rel="stylesheet" href="{{ asset('theme/css/movie.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/static') }}">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> --}}
    <style>
        body .dark .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link .active {
            color: rgb(19, 18, 18);
            background-color: white
        }

        .text_bold {
            font-family: Inter-bold !important;
            font-size: 24px
        }

        .text_bold2 {
            font-family: Inter-bold !important;
            font-size: 22px
        }

        .medium {
            font-family: Inter-Medium !important;
            font-size: 20px
        }

        .regular {
            font-family: Inter-Regular !important;
            font-size: 16px
        }

        .set_heigth {
            /* height: 200px; */
        }

        /* .sidebar_design {
                           
                            background-color: #212121 !important
                        }
                        .card1__head{
                            border-bottom: 1px solid #212121 !important
                        }
                        .card1__note{
                            border-bottom: 1px solid #212121 !important
                        } */

        /* .sidebar_right_design {
                            width: 720px !important;
                            height: 405px !important;
                            background-color: #212121 !important
                        } */
    </style>
</head>

<body class="dark" style="background-color: #000">
    <div class="container-fluid pt-5">

        <a href="#" class="text-white text_bold"><img style="width:48px !important" class="ml-3 mr-3 mb-3 header7__pic header7__pic_white "
            src="{{ asset('theme/img/logo.png') }}" alt="" />Yuvie LLC</a>
        <div class="page2__row">

            <div class="page2__col page2__col_w25">

                <div class="card1 sidebar_design">
                    <div class="card1__head">
                        <div class="card1__category p-2 medium ">Contact</div>
                    </div>
                    <div class="card1__head">
                        <div class="ava active"><img style="width:48px;height:48px;" class="ava__pic"
                                src="{{ asset('theme/img/ava-13.png') }}" /></div>
                        <div class="card1__category p-3 text_bold2 ">User Name</div>
                    </div>
                    <div class="card1__body">
                        <div class="card1__note regular ">
                            jhon@gmail.com
                            <p style="color: #3498DB ">+974525552656</p>
                        </div>
                        <div class="card1__note ">
                            <h6 class="medium">Address</h6>
                            <p class="regular">1001 Longwood Rd, Kennett Square, PA 19348
                                USA</p>
                        </div>
                        <div class="card1__note ">
                            <h6 class="medium ">Direction</h6>
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18910.00283827443!2d-8.992607651389052!3d53.66925103856454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x485bfc7c76bbf847%3A0xa00c7a99731a0b0!2sBallindine%20East%2C%20Ballindine%2C%20Co.%20Mayo%2C%20Ireland!5e0!3m2!1sen!2s!4v1676623615147!5m2!1sen!2s"
                                width="256px" height="128px" style="border-radius:5%;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>

            </div>
            <div class="page2__col page2__col_w75">
                <div class="post js-post sidebar_right_design">

                    <div class="post__item">
                        <div class="post__body">
                            <div class="card1__category text_bold ">Video Nmae</div>
                            <div class="post__gallery">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="text-center  ">
                                            <video id="example">
                                                <source src="{{$url}}" height="400px !important" type="video/mp4">
                                            </video>
                                            {{-- <video id="example" style="width:720px !important;height:405px !important">
                                                            <source src="{{ $video_url . '/' . $record->video }}" type="video/mp4">
                                                        </video> --}}
                                            <button type="button"
                                                class=" text-white btn btn-sm medium rounded-pill  mt-4 pl-5 pr-5"
                                                style="background-color:#ff5926">Book A Test drive
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="card1">
                                            <div class="card1__head">
                                                <div class="card1__category medium">Related Videos</div>
                                            </div>
                                            <div class="card1__body">
                                                <div class="card1__gallery">
                                                    <div class="mb-3 set_heigth">
                                                        <video class="" id="example2" width="100%">
                                                            <source controls="" preload="" src="http://techslides.com/demos/sample-videos/small.mp4"
                                                                type="video/mp4">

                                                        </video>
                                                    </div>
                                                    <div class="mb-3 set_heigth">
                                                        <video class="" id="example3" width="100%">
                                                            <source controls="" preload="" src="http://techslides.com/demos/sample-videos/small.mp4"
                                                                type="video/mp4">
                                                        </video>
                                                    </div>
                                                    <div class="mb-3 set_heigth">
                                                        <video class="" id="example4" width="100%">
                                                            <source controls="" preload="" src="http://techslides.com/demos/sample-videos/small.mp4"
                                                                type="video/mp4">

                                                        </video>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- <div class="post__item">
                                    <div class="post__body">
                                        <div class="card1__category text_bold">{{ $record->title }}</div>
                                        <div class="post__gallery">
                                                    <div class="text-center ">
                                                        <video id="example" style="width:720px !important;height:405px !important">
                                                            <source src="{{ $video_url . '/' . $record->video }}" type="video/mp4">
                                                        </video>
                                                        <button type="button"
                                                            class=" text-white btn btn-sm medium rounded-pill  mt-4 pl-5 pr-5"
                                                            style="background-color:#ff5926">Book A Test drive
                                                        </button>
                                                    </div>
                                        </div>
                                    </div>
                                    <div class="post__item">
                                        <div class="post__body">
                                            <div class="card1">
                                                <div class="card1__head">
                                                    <div class="card1__category medium">Related Videos</div>
                                                </div>
                                                <div class="card1__body">
                                                    <div class="card1__gallery">
                                                        <div class="card1__photo">
                                                            <video id="example2" width="100%">
                                                                <source controls="" preload=""
                                                                    src="{{ $video_url . '/' . $record->video }}" type="video/mp4">
                
                                                            </video>
                
                
                                                        </div>
                                                        <div class="card1__photo">
                                                            <video id="example3" width="100%">
                                                                <source src="{{ $video_url . '/' . $record->video }}" type="video/mp4">
                                                            </video>
                
                
                                                        </div>
                                                        <div class="card1__photo">
                                                            <video id="example4" width="100%">
                                                                <source src="{{ $video_url . '/' . $record->video }}" type="video/mp4">
                
                                                            </video>
                
                                                        </div>
                
                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                
                                    </div>
                                </div> --}}
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
    @include('admin.layout.partials.script')
    <script src="{{ asset('theme/js/movie.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var demo1 = new Moovie({
                selector: "#example",
                dimensions: {
                    width: "100%",
                },
                config: {
                    storage: {
                        captionOffset: false,
                        playrateSpeed: false,
                        captionSize: false
                    }
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            var demo1 = new Moovie({
                selector: "#example2",
                dimensions: {
                    width: "100%"
                },
                config: {
                    storage: {
                        captionOffset: false,
                        playrateSpeed: false,
                        captionSize: false
                    }
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            var demo1 = new Moovie({
                selector: "#example3",
                dimensions: {
                    width: "100%"
                },
                config: {
                    storage: {
                        captionOffset: false,
                        playrateSpeed: false,
                        captionSize: false
                    }
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            var demo1 = new Moovie({
                selector: "#example4",
                dimensions: {
                    width: "100%"
                },
                config: {
                    storage: {
                        captionOffset: false,
                        playrateSpeed: false,
                        captionSize: false
                    }
                }
            });
        });
    </script>
</body>

</html>
