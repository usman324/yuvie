<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('theme/img/favicon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('theme/img/favicon.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('theme/img/favicon.png') }}">
{{-- <link rel="manifest" href="{{asset("theme/img/site.webmanifest")}}"> --}}
{{-- <link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5"> --}}
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta name="description" content="Page description">
<!--Twitter Card data-->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="Page Title">
<meta name="twitter:description" content="Page description less than 200 characters">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="http://www.example.com/image.jpg">
<!--Open Graph data-->
<meta property="og:title" content="Title Here">
<meta property="og:type" content="article">
<meta property="og:url" content="http://www.example.com/">
<meta property="og:image" content="http://example.com/image.jpg">
<meta property="og:description" content="Description Here">
<meta property="og:site_name" content="Site Name, i.e. Moz">
<meta property="fb:admins" content="Facebook numeric ID">
<link rel="stylesheet" media="all" href="{{ asset('theme/css/app.css') }}">
<link rel="stylesheet" media="all" href="{{ asset('theme/css/sweetalert.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" media="all" href="{{ asset('theme/css/toastr.min.css') }}">
<script>
    var viewportmeta = document.querySelector('meta[name="viewport"]');
    if (viewportmeta) {
        if (screen.width < 375) {
            var newScale = screen.width / 375;
            viewportmeta.content = 'width=375, minimum-scale=' + newScale +
                ', maximum-scale=1.0, user-scalable=no, initial-scale=' + newScale + '';
        } else {
            viewportmeta.content = 'width=device-width, maximum-scale=1.0, initial-scale=1.0';
        }
    }
</script>
@yield('style')
