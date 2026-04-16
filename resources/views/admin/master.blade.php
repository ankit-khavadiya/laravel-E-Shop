<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="canonical" href="{{request()->url()}}"/>
    {{--  header links(like css or js or  all lib links)  --}}
    @include('admin.layouts.header.header-links')
    @yield('schema')
</head>
<body>
    <div class="wrapper">

        {{--    Sidebar     --}}
        @include('admin.layouts.header.sidebar')
        <div class="main">
            {{--      Header      --}}
            @include('admin.layouts.header.header')
            <div class="content">
                {{--        Page content(all section like hero)        --}}
                @yield('page-content')
            </div>
        </div>
    </div>
    {{--  all Model  --}}
    @yield('model')
    {{--  Footer  --}}
    @include('admin.layouts.footer.footer')
    {{--  Footer links(like js)  --}}
    @include('admin.layouts.footer.footer-links')
    {{--  Common js  --}}
    @include('admin.layouts.common-js.common-js')
    {{--  Specific Page js  --}}
    @yield('js')
    @stack('scripts')
</body>
</html>
