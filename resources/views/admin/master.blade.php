<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="canonical" href="{{request()->url()}}"/>

    @include('admin.layouts.header.header-links')
    @yield('schema')
</head>
<body>
    <div class="wrapper">
        @include('admin.layouts.header.sidebar')
        <div class="main">
            @include('admin.layouts.header.header')
            <div class="content">
                @yield('page-content')
            </div>
        </div>
    </div>
    @yield('model')
    @include('admin.layouts.footer.footer')
    @include('admin.layouts.footer.footer-links')
    @include('admin.layouts.common-js.common-js')

    @yield('js')
    @stack('scripts')
</body>
</html>
