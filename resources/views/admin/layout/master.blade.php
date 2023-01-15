<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layout.partials.style')
</head>

<body>
    <div class="out">
        <div class="page7 js-page7">
            @include('admin.layout.header')
            <div class="page7__wrapper">
                @include('admin.layout.sidebar')
                <div class="page7__container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('admin.layout.partials.script')
    {{-- @include('admin.layout.partials.toast') --}}
</body>

</html>
