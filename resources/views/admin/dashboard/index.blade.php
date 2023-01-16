@extends('admin.layout.master')
@section('style')
    <title>YuVie-Business: Admin</title>
@stop
@section('content')
    <div class="page__content">
        <div class="dashboard">
            <div class="dashboard__start"><strong>Dashboard</strong></div>
            <div class="dashboard__container">
                <div class="dashboard__section">
                    <div class="dashboard__head">
                        
                    </div>
                    <div class="dashboard__body">
                        <div class="dashboard__list">
                            <div class="card card_big">
                                <div class="card__team">
                                    <div class="card__logo"><img class="card__pic" src="{{asset("theme/img/logo-team-1.png")}}"></div>
                                    <div class="card__title">Company</div>
                                </div>
                            </div>
                            <div class="card card_big">
                                <div class="card__team">
                                    <div class="card__logo"><img class="card__pic" src="{{asset("theme/img/logo-team-1.png")}}"></div>
                                    <div class="card__title">Users</div>
                                </div>
                            </div>
                            <div class="card card_big">
                                <div class="card__team">
                                    <div class="card__logo"><img class="card__pic" src="{{asset("theme/img/logo-team-1.png")}}"></div>
                                    <div class="card__title">Videos</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                {{-- <div class="dashboard__section">
                    <div class="dashboard__head">
                        <div class="dashboard__category">Projects</div>
                        <div class="options js-options"><button class="options__btn js-options-btn"><svg
                                    class="icon icon-dots">
                                    <use xlink:href="img/sprite.svg#icon-dots"></use>
                                </svg></button>
                            <div class="options__dropdown js-options-dropdown">
                                <div class="options__stage">List Actions<button
                                        class="options__close js-options-close"><svg class="icon icon-close">
                                            <use xlink:href="img/sprite.svg#icon-close"></use>
                                        </svg></button></div>
                                <div class="options__group"><a class="options__link" href="#">Add New Teams… </a><a
                                        class="options__link" href="#">Edit Current Teams…</a><a
                                        class="options__link" href="#">Add New Member…</a><a class="options__link"
                                        href="#">Remove Current Member…</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard__body">
                        <div class="dashboard__list">
                            <div class="card card_big">
                                <div class="card__head"><a class="card__title js-popup-open" href="#popup-details"
                                        data-effect="mfp-zoom-in">Product Preview & Mock up for Marketing</a>
                                    <div class="card__info">Iconspace Team</div>
                                    <div class="options js-options"><button class="options__btn js-options-btn"><svg
                                                class="icon icon-dots">
                                                <use xlink:href="img/sprite.svg#icon-dots"></use>
                                            </svg></button>
                                        <div class="options__dropdown js-options-dropdown">
                                            <div class="options__stage">Option<button
                                                    class="options__close js-options-close"><svg class="icon icon-close">
                                                        <use xlink:href="img/sprite.svg#icon-close"></use>
                                                    </svg></button></div>
                                            <div class="options__group"><a class="options__item" href="#">
                                                    <div class="options__info">Add New Projects…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects more organize</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Import Project from Outside…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Share Your Projects to…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card__parameters">
                                    <div class="card__parameter"><svg class="icon icon-add">
                                            <use xlink:href="img/sprite.svg#icon-add"></use>
                                        </svg>13</div>
                                    <div class="card__parameter card__parameter_time orange"><svg class="icon icon-clock">
                                            <use xlink:href="img/sprite.svg#icon-clock"></use>
                                        </svg>7 days left</div>
                                </div>
                                <div class="card__scale">
                                    <div class="card__percent">85%</div>
                                    <div class="card__line">
                                        <div class="card__progress" style="width: 85%;"></div>
                                    </div>
                                </div>
                                <div class="users">
                                    <div class="users__item" style="background-color: #FFC542">KA</div>
                                    <div class="users__item" style="background-color: #A461D8">RR</div>
                                    <div class="users__item"><img class="users__pic" src="img/ava-1.png" alt="">
                                    </div>
                                    <div class="users__item"><img class="users__pic" src="img/ava-2.png" alt="">
                                    </div>
                                    <div class="users__item users__item_counter">+3</div>
                                </div>
                            </div>
                            <div class="card card_big">
                                <div class="card__head"><a class="card__title js-popup-open" href="#popup-details"
                                        data-effect="mfp-zoom-in">Circle - Dashboard, Stats, and UI Kit</a>
                                    <div class="card__info">Iconspace Team</div>
                                    <div class="options js-options"><button class="options__btn js-options-btn"><svg
                                                class="icon icon-dots">
                                                <use xlink:href="img/sprite.svg#icon-dots"></use>
                                            </svg></button>
                                        <div class="options__dropdown js-options-dropdown">
                                            <div class="options__stage">Option<button
                                                    class="options__close js-options-close"><svg class="icon icon-close">
                                                        <use xlink:href="img/sprite.svg#icon-close"></use>
                                                    </svg></button></div>
                                            <div class="options__group"><a class="options__item" href="#">
                                                    <div class="options__info">Add New Projects…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects more organize</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Import Project from Outside…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Share Your Projects to…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card__parameters">
                                    <div class="card__parameter"><svg class="icon icon-add">
                                            <use xlink:href="img/sprite.svg#icon-add"></use>
                                        </svg>5</div>
                                    <div class="card__parameter card__parameter_time red"><svg class="icon icon-clock">
                                            <use xlink:href="img/sprite.svg#icon-clock"></use>
                                        </svg>1 days left</div>
                                </div>
                                <div class="card__scale">
                                    <div class="card__percent">75%</div>
                                    <div class="card__line">
                                        <div class="card__progress" style="width: 75%;"></div>
                                    </div>
                                </div>
                                <div class="users">
                                    <div class="users__item"><img class="users__pic" src="img/ava-1.png" alt="">
                                    </div>
                                    <div class="users__item" style="background-color: #A461D8">RR</div>
                                </div>
                            </div>
                            <div class="card card_big">
                                <div class="card__head"><a class="card__title js-popup-open" href="#popup-details"
                                        data-effect="mfp-zoom-in">Square - Social Media Plan </a>
                                    <div class="card__info">Uranus Team</div>
                                    <div class="options js-options"><button class="options__btn js-options-btn"><svg
                                                class="icon icon-dots">
                                                <use xlink:href="img/sprite.svg#icon-dots"></use>
                                            </svg></button>
                                        <div class="options__dropdown js-options-dropdown">
                                            <div class="options__stage">Option<button
                                                    class="options__close js-options-close"><svg class="icon icon-close">
                                                        <use xlink:href="img/sprite.svg#icon-close"></use>
                                                    </svg></button></div>
                                            <div class="options__group"><a class="options__item" href="#">
                                                    <div class="options__info">Add New Projects…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects more organize</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Import Project from Outside…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Share Your Projects to…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card__parameters">
                                    <div class="card__parameter"><svg class="icon icon-add">
                                            <use xlink:href="img/sprite.svg#icon-add"></use>
                                        </svg>3</div>
                                    <div class="card__parameter card__parameter_time orange"><svg class="icon icon-clock">
                                            <use xlink:href="img/sprite.svg#icon-clock"></use>
                                        </svg>8 days left</div>
                                </div>
                                <div class="card__scale">
                                    <div class="card__percent">65%</div>
                                    <div class="card__line">
                                        <div class="card__progress" style="width: 65%;"></div>
                                    </div>
                                </div>
                                <div class="users">
                                    <div class="users__item" style="background-color: #FF9AD5">T</div>
                                    <div class="users__item"><img class="users__pic" src="img/ava-1.png" alt="">
                                    </div>
                                    <div class="users__item"><img class="users__pic" src="img/ava-2.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="card card_big">
                                <div class="card__head"><a class="card__title js-popup-open" href="#popup-details"
                                        data-effect="mfp-zoom-in">Project Management Tool Dashboard</a>
                                    <div class="card__info">Uranus Team</div>
                                    <div class="options js-options"><button class="options__btn js-options-btn"><svg
                                                class="icon icon-dots">
                                                <use xlink:href="img/sprite.svg#icon-dots"></use>
                                            </svg></button>
                                        <div class="options__dropdown js-options-dropdown">
                                            <div class="options__stage">Option<button
                                                    class="options__close js-options-close"><svg class="icon icon-close">
                                                        <use xlink:href="img/sprite.svg#icon-close"></use>
                                                    </svg></button></div>
                                            <div class="options__group"><a class="options__item" href="#">
                                                    <div class="options__info">Add New Projects…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects more organize</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Import Project from Outside…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Share Your Projects to…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card__parameters">
                                    <div class="card__parameter"><svg class="icon icon-add">
                                            <use xlink:href="img/sprite.svg#icon-add"></use>
                                        </svg>1</div>
                                    <div class="card__parameter card__parameter_time"><svg class="icon icon-clock">
                                            <use xlink:href="img/sprite.svg#icon-clock"></use>
                                        </svg>10 days left</div>
                                </div>
                                <div class="card__scale">
                                    <div class="card__percent">30%</div>
                                    <div class="card__line">
                                        <div class="card__progress" style="width: 30%;"></div>
                                    </div>
                                </div>
                                <div class="users">
                                    <div class="users__item"><img class="users__pic" src="img/ava-1.png" alt="">
                                    </div>
                                    <div class="users__item" style="background-color: #82C43C">EL</div>
                                    <div class="users__item" style="background-color: #FFC542">P</div>
                                    <div class="users__item"><img class="users__pic" src="img/ava-2.png" alt="">
                                    </div>
                                    <div class="users__item users__item_counter">+10</div>
                                </div>
                            </div>
                            <div class="card card_big">
                                <div class="card__head"><a class="card__title js-popup-open" href="#popup-details"
                                        data-effect="mfp-zoom-in">Development - Circle Website</a>
                                    <div class="card__info">Iconspace Team</div>
                                    <div class="options js-options"><button class="options__btn js-options-btn"><svg
                                                class="icon icon-dots">
                                                <use xlink:href="img/sprite.svg#icon-dots"></use>
                                            </svg></button>
                                        <div class="options__dropdown js-options-dropdown">
                                            <div class="options__stage">Option<button
                                                    class="options__close js-options-close"><svg class="icon icon-close">
                                                        <use xlink:href="img/sprite.svg#icon-close"></use>
                                                    </svg></button></div>
                                            <div class="options__group"><a class="options__item" href="#">
                                                    <div class="options__info">Add New Projects…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects more organize</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Import Project from Outside…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a><a class="options__item" href="#">
                                                    <div class="options__info">Share Your Projects to…</div>
                                                    <div class="options__text">In this menu you can add new projects. It
                                                        can make easlily you to make your projects.</div>
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card__parameters">
                                    <div class="card__parameter"><svg class="icon icon-add">
                                            <use xlink:href="img/sprite.svg#icon-add"></use>
                                        </svg>2</div>
                                    <div class="card__parameter card__parameter_time"><svg class="icon icon-clock">
                                            <use xlink:href="img/sprite.svg#icon-clock"></use>
                                        </svg>14 days left</div>
                                </div>
                                <div class="card__scale">
                                    <div class="card__percent">20%</div>
                                    <div class="card__line">
                                        <div class="card__progress" style="width: 20%;"></div>
                                    </div>
                                </div>
                                <div class="users">
                                    <div class="users__item"><img class="users__pic" src="img/ava-1.png" alt="">
                                    </div>
                                    <div class="users__item"><img class="users__pic" src="img/ava-2.png" alt="">
                                    </div>
                                    <div class="users__item" style="background-color: #50B5FF">AF</div>
                                </div>
                            </div><a class="card card_add" href="#">
                                <div class="card__add">
                                    <div class="card__icon"><svg class="icon icon-plus">
                                            <use xlink:href="img/sprite.svg#icon-plus"></use>
                                        </svg></div>
                                    <div class="card__text">Add projects</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@stop
