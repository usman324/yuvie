<div class="sidebar7 js-sidebar7">
    <div class="sidebar7__top">
        <button class="sidebar7__close js-sidebar7-close">
            <svg class="icon icon-close">
                <use xlink:href="{{ asset('theme/img/sprite.svg#icon-close') }}"></use>
            </svg>
        </button>
        <a class="sidebar7__logo" href="#">
            <img class="sidebar7__pic sidebar7__pic_black" src="{{ asset('theme/img/logo.svg') }}" alt="" />
            <img class="sidebar7__pic sidebar7__pic_white" src="{{ asset('theme/img/logo-white.svg') }}"
                alt="" />
        </a>
    </div>
    <div class="sidebar7__wrapper">
        <div class="sidebar7__box">
            <div class="sidebar7__category">Main</div>
            <div class="sidebar7__menu">
                <a class="sidebar7__item {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{url('admin/dashboard')}}">
                    <svg class="icon icon-dashboard">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-dashboard') }}"></use>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>
        <div class="sidebar7__box">
            <div class="sidebar7__category">Management </div>
            <div class="sidebar7__menu ">
                <a class="sidebar7__item {{ request()->is('admin/users')|| request()->is('admin/users/create') ? 'active' : '' }}" href="{{ url('admin/users') }}">
                    <svg class="icon icon-messages">
                        <use xlink:href="{{ asset('theme/img/sprite.svg#icon-sale') }}"></use>
                    </svg>Users
                </a>
            </div> 
            
        </div>
        
    </div>
    
    <label class="switch switch_theme">
        
        <input class="switch__input js-switch-theme" type="checkbox" />
        <span class="switch__in">
            <span class="switch__box"></span>
            <span class="switch__icon">
                <svg class="icon icon-moon">
                    <use xlink:href="{{asset("theme/img/sprite.svg#icon-moon")}}"></use>
                </svg>
                <svg class="icon icon-sun">
                    <use xlink:href="{{asset("theme/img/sprite.svg#icon-sun")}}"></use>
                </svg>
            </span>
        </span>
    </label>
    <label class="switch switch_theme">
        
        <input class="switch__input js-switch-theme" type="checkbox" />
        <span class="switch__in">
            <span class="switch__box"></span>
            <span class="switch__icon">
                <svg class="icon icon-moon">
                    <use xlink:href="{{asset("theme/img/sprite.svg#icon-moon")}}"></use>
                </svg>
                <svg class="icon icon-sun">
                    <use xlink:href="{{asset("theme/img/sprite.svg#icon-sun")}}"></use>
                </svg>
            </span>
        </span>
    </label>
</div>
