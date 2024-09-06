@extends('admin.layout.master')
@section('style')
    <title>YuVie-Business: Admin</title>
@stop
@section('content')
    <div class="overview">
        <div class="overview__list">

            <div class="overview__card" style="height:110px">
                <div class="overview__main">
                    <div class="overview__title">Companies</div>
                </div>
                <div class="overview__flex">
                    <div class="overview__number">{{ $companies }}</div>
                    <div class="overview__status overview__status_up">
                        <svg class="icon icon-arrow-top">
                            <use xlink:href="img/sprite.svg#icon-arrow-top"></use>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="overview__card" style="height:110px">
                <div class="overview__main">
                    <div class="overview__title">Users</div>
                </div>
                <div class="overview__flex">
                    <div class="overview__number">{{ $users }}</div>
                    <div class="overview__status overview__status_up">
                        <svg class="icon icon-arrow-top">
                            <use xlink:href="img/sprite.svg#icon-arrow-top"></use>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="overview__card" style="height:110px">
                <div class="overview__main">
                    <div class="overview__title">Videos</div>
                </div>
                <div class="overview__flex">
                    <div class="overview__number">{{ $videos }}</div>
                    <div class="overview__status overview__status_up">
                        <svg class="icon icon-arrow-top">
                            <use xlink:href="img/sprite.svg#icon-arrow-top"></use>
                        </svg>
                    </div>
                </div>
            </div>

        </div>
        <div class="overview__row">
            <div class="overview__col overview__col_w67">
                <div class="overview__card">
                    <div class="overview__head">
                        <div class="overview__title">Sales Figures</div>
                        <div class="overview__legend">
                            <div class="overview__parameter">
                                <div class="overview__bg" style="background-color: #0062FF;"></div>
                                <div class="overview__text">Users</div>
                            </div>
                            <div class="overview__parameter">
                                <div class="overview__bg" style="background-color: #3DD598;"></div>
                                <div class="overview__text">Videos</div>
                            </div>
                        </div>
                    </div>
                    <div class="overview__chart overview__chart_sales-figures">
                        <div id="chart-sales-figures"></div>
                    </div>
                </div>
            </div>
            <div class="overview__col overview__col_w33">
                <div class="overview__card overview__card_p0">
                    <div class="statistics">
                        <div class="statistics__body">
                            <div class="statistics__top">
                                <div class="statistics__title">New Customers</div>
                                <div class="options2 js-options"><button class="options2__btn js-options-btn"><svg
                                            class="icon icon-dots">
                                            <use xlink:href="img/sprite.svg#icon-dots"></use>
                                        </svg></button>
                                    <div class="options2__dropdown js-options-dropdown"><a class="options2__link"
                                            href="#">Remove Notifications</a><a class="options2__link"
                                            href="#">Turn
                                            Off Notifications from Janeta</a></div>
                                </div>
                            </div>
                            <div class="statistics__group">
                                @foreach ($latest_companies as $item)
                                    <div class="statistics__item">
                                        <div class="ava">
                                            @if ($item?->companyBranding->profile_logo)
                                                <img class="ava__pic"
                                                    src="{{ $image_url . '/' . $item?->companyBranding->profile_logo }}"
                                                    alt="">
                                            @else
                                                <img class="ava__pic" src="{{ asset('theme/img/user.jpeg') }}"
                                                    alt="">
                                            @endif

                                        </div>
                                        <div class="statistics__details">
                                            <div class="statistics__man">{{ $item->first_name . ' ' . $item->last_name }}
                                            </div>
                                            <div class="statistics__id">Address <br>{{ $item?->companyDetail->address }}
                                            </div>
                                        </div>
                                        <div class="statistics__actions">
                                            <button class="statistics__action"><svg class="icon icon-email">
                                                    <use xlink:href="img/sprite.svg#icon-email"></use>
                                                </svg></button><button class="statistics__action">
                                                <svg class="icon icon-block">
                                                    <use xlink:href="img/sprite.svg#icon-block"></use>
                                                </svg></button>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="statistics__foot"><a class="statistics__view" href="{{ url('admin/companies') }}">View
                                more Customers</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overview__row">
            <div class="overview__col overview__col_w75">
                <div class="overview__card overview__card_p0 overview__card_location">
                    <div class="overview__cell">
                        <div class="overview__title">Top Retail Sales Locations</div>
                        <div class="overview__flex">
                            <div class="overview__number">15.870</div>
                            <div class="overview__flag"><img class="overview__pic" src="img/flag-usa.svg" alt="">
                            </div>
                        </div>
                        <div class="overview__info">Our most customers in US</div>
                        <div class="overview__legend overview__legend_group">
                            <div class="overview__parameter">
                                <div class="overview__bg" style="background-color: #0062FF;"></div>
                                <div class="overview__text">Massive</div>
                                <div class="overview__value">15.7k</div>
                            </div>
                            <div class="overview__parameter">
                                <div class="overview__bg" style="background-color: #FF974A;"></div>
                                <div class="overview__text">Large</div>
                                <div class="overview__value">4.9k</div>
                            </div>
                            <div class="overview__parameter">
                                <div class="overview__bg" style="background-color: #FFC542;"></div>
                                <div class="overview__text">Medium</div>
                                <div class="overview__value">2.4k</div>
                            </div>
                            <div class="overview__parameter">
                                <div class="overview__bg" style="background-color: #E2E2EA;"></div>
                                <div class="overview__text">Small</div>
                                <div class="overview__value">980</div>
                            </div>
                        </div>
                    </div>
                    <div class="overview__cell">
                        <div class="overview__map">
                            <div class="js-map-svg" style="width: 100%; height: 355px;"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@stop
@section('script')
    @include('admin.dashboard.partial.chart')
@stop
