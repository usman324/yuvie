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
    <div class="container pt-5">

        <a href="#" class="text-white text_bold"><img style="width:48px !important"
                class="ml-3 mr-3 mb-3 header7__pic header7__pic_white " src="{{ asset('theme/img/logo.png') }}"
                alt="" />Yuvie LLC</a>
        <div class="page2__row">
            <div class="page2__col page2__col_w100">
                <div class="post js-post sidebar_right_design">
                    <div class="post__item">
                        <div class="post__body">
                            <div class="post__gallery">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center  ">
                                            <video id="example">
                                                <source src="{{ $url }}" 
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
    </script>
</body>

</html>
