<div class="header7 js-header7">
    <button class="header7__burger js-header7-burger">
        <svg class="icon icon-burger">
            <use xlink:href="{{ asset('theme/img/sprite.svg#icon-burger') }}"></use>
        </svg>
    </button>
    <a class="header7__logo" href="#">
        <img class="header7__pic header7__pic_black w-25" src="{{ asset('theme/img/logo.png') }}" alt="" />
        <img class="header7__pic header7__pic_white w-25" src="{{ asset('theme/img/logo.png') }}" alt="" />
    </a>
    <div class="header7__search"><button class="header7__open"><svg class="icon icon-search">
                <use xlink:href="{{ asset('theme/img/sprite.svg#icon-search') }}"></use>
            </svg>
        </button>
        <input class="header7__input" type="text" placeholder="Search…" />
    </div>
    <div class="header7__control">
        {{-- <button class="header7__notifications active">
            <svg class="icon icon-bell">
                <use xlink:href="{{ asset('theme/img/sprite.svg#icon-bell') }}"></use>
            </svg>
        </button> --}}

        <button type="button"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"
            class="header7__notifications">
            <svg class="icon icon-bell">
                <use xlink:href="{{ asset('theme/img/sprite.svg#icon-logout') }}"></use>
            </svg>
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <a class="header7__user" href="#">
            <div class="ava">
                <img class="ava__pic" src="{{ asset('theme/img/user.jpeg') }}" alt="" />
            </div>
            <div class="header7__box">
                <div class="header7__man">{{ auth()->user()->first_name.' '.auth()->user()->last_name }}</div>
                {{-- <div class="header7__post">{{ auth()->user()->last_name . '' . auth()->user()->first_name }}</div> --}}
            </div>
        </a>
    </div>
    <div class="header7__bg js-header7-bg"></div>
</div>
