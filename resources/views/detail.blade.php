<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>YuVie LLC</title>
    <link rel="apple-touch-icon" sizes="180x180" href="https://yuvie.bhattimobiles.com/public/theme/img/favicon.png">
<link rel="icon" type="image/png" sizes="32x32" href="https://yuvie.bhattimobiles.com/public/theme/img/favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="https://yuvie.bhattimobiles.com/public/theme/img/favicon.png">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
</head>

<body>


    <section class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="yu-container">
                        <div class="yu-sidebar">
                            <div class="yu-logo-container">
                                <div class="yu-logo">
                                    <img src="{{ asset('assets/images/logo.png') }}">
                                </div>
                                <div class="yu-logo-text">YuVieLLC</div>
                            </div>
                            <div class="yu-sidebar-container">
                                <div class="yu-contact-Wrapper">
                                    <div class="yu-contact-title">Contact</div>
                                    <div class="yu-contact-avatar">
                                        <div class="yu-contact-avatar-img">
                                            @if ($record->user?->image)
                                                <img class="rounded-5"
                                                    src="{{ $image_url . '/' . $record->user->image }}">
                                            @else
                                                <img class="rounded-circle" src="{{ asset('theme/img/avatar.png') }}">
                                            @endif
                                        </div>
                                        <div class="yu-contact-name">
                                            {{ $record->user?->first_name . ' ' . $record->user?->last_name }}</div>
                                    </div>
                                    <div class="yu-contact-email">{{ $record->user?->email }}</div>
                                    <div class="yu-contact-number">
                                        @if ($user?->company->companyDetail->phone)
                                            {{ $user?->company->companyDetail->phone }}
                                        @else
                                            +82420232032
                                        @endif
                                    </div>
                                    <div class="yu-contact-address-container">
                                        <div class="yu-contact-address-title">Address</div>
                                        <div class="yu-contact-address">
                                            @if ($user?->company->companyDetail->address)
                                                {{ $user?->company->companyDetail->address }}<br>
                                                <!--{{ $user?->company->state->name }}<br>-->
                                                {{ $user?->company->zip }}<br>
                                                {{ $user?->company->city_name }}<br>
                                                United States

                                            @else
                                                1125 NE 125th St #400<br>
                                                North Miami<br>
                                                FL 33161<br>
                                                United States
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="yu-map-wrapper">
                                    <div class="yu-map-title">Directions</div>
                                    {{-- @dd($user?->company->companyDetail->latitude) --}}
                                    <div class="yu-map-container">
                                        {{-- @if ($user?->company->companyDetail->latitude)
                                            <iframe
                                                src="https://maps.google.com/maps?q='{{ $user?->company->companyDetail->latitude }}','{{ $user?->company->companyDetail->longitude }}'&hl=es&z=14&amp;output=embed"
                                                height="128" style="border:0; width: 100%" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        @else
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d45614.35857312407!2d-74.21909411789736!3d40.79675142147009!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1677015161918!5m2!1sen!2s"
                                                height="128" style="border:0; width: 100%" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        @endif --}}
                                        <div id="gmaps-markers" class="gmaps"
                                            style="height:190px !important;border:0; width: 100%;border-radius: 8px;"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($record->type == 'landscape')
                            <div class="yu-video-Wrapper">
                                <div class="yu-video-title">{{ $record->title }}</div>
                                <div class="yu-video-container">
                                    <video controls id="primaryVideo">
                                        <source src="{{ $url }}" type="video/mp4" />
                                    </video>
                                </div>
                                <div class="book-test-drive-container">
                                    <button class="btn btn-primary">Book a Test Drive</button>
                                </div>
                                <div class="yu-related-videos-wrapper">
                                    <div class="yu-related-video-title">Related videos</div>
                                    <div class="yu-related-video-container">
                                        <div class="yu-related-video-thumbnail">
                                            <a href="#!">
                                                <img class="play-btn"
                                                    src="{{ asset('assets/images/play-video.svg') }}">
                                                <img class="vid-thumb" src="{{ asset('assets/images/thumb1.jpg') }}">
                                            </a>
                                        </div>
                                        <div class="yu-related-video-thumbnail">
                                            <a href="#!">
                                                <img class="play-btn"
                                                    src="{{ asset('assets/images/play-video.svg') }}">
                                                <img class="vid-thumb" src="{{ asset('assets/images/thumb2.jpg') }}">
                                            </a>
                                        </div>
                                        <div class="yu-related-video-thumbnail">
                                            <a href="#!">
                                                <img class="play-btn"
                                                    src="{{ asset('assets/images/play-video.svg') }}">
                                                <img class="vid-thumb" src="{{ asset('assets/images/thumb3.jpg') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="yu-video-Wrapper yu-video-Wrapper-vertical">
                                <div class="yu-video-title">{{ $record->title }}</div>
                                <div class="yu-video-main-container">
                                    <div class="yu-video-main-container-left">
                                        <div class="yu-video-container">
                                            <video controls id="primaryVideo">
                                                <source src="{{ $url }}" type="video/mp4" />
                                            </video>
                                        </div>
                                        <div class="book-test-drive-container">
                                            <button class="btn btn-primary">Book a Test Drive</button>
                                        </div>
                                    </div>

                                    <div class="yu-related-videos-wrapper">
                                        <div class="yu-related-video-title">Related videos</div>
                                        <div class="yu-related-video-container">
                                            <div class="yu-related-video-thumbnail">
                                                <a href="#!">
                                                    <img class="play-btn"
                                                        src="{{ asset('assets/images/play-video.svg') }}">
                                                    <img class="vid-thumb"
                                                        src="{{ asset('assets/images/thumb1.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="yu-related-video-thumbnail">
                                                <a href="#!">
                                                    <img class="play-btn"
                                                        src="{{ asset('assets/images/play-video.svg') }}">
                                                    <img class="vid-thumb"
                                                        src="{{ asset('assets/images/thumb2.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="yu-related-video-thumbnail">
                                                <a href="#!">
                                                    <img class="play-btn"
                                                        src="{{ asset('assets/images/play-video.svg') }}">
                                                    <img class="vid-thumb"
                                                        src="{{ asset('assets/images/thumb3.jpg') }}">
                                                </a>
                                            </div>
                                            <div class="yu-related-video-thumbnail">
                                                <a href="#!">
                                                    <img class="play-btn"
                                                        src="{{ asset('assets/images/play-video.svg') }}">
                                                    <img class="vid-thumb"
                                                        src="{{ asset('assets/images/thumb4.jpg') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>



    </section>

    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script>
    <script src="{{ asset('assets/js/gmaps/gmaps.min.js') }}"></script>
    @include('partial.map')
</body>

</html>
