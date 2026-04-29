<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Shop - Premium Online Store')</title>
    @include('web.layouts.header.header-links')
    @yield('schema')
</head>
<body>
{{--    --}}{{--    Sidebar     --}}
{{--    @include('')--}}

    {{--      Header      --}}
    @include('web.layouts.header.header')
    <!-- Main Content -->
    <main>
        {{--        Page content(all section like hero)        --}}
        @yield('page-content')
    </main>
    {{--  all Model  --}}
    @yield('model')
    {{--  Footer  --}}
    @include('web.layouts.footer.footer')
    {{--  Footer links(like js)  --}}
    @include('web.layouts.footer.footer-links')
    {{--  Common js  --}}
    @include('web.layouts.common-js.common-js')
    {{--  Specific Page js  --}}
    @yield('webJs')

    <!-- Search Modal -->
    <div class="modal fade search-modal" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="search-container">
                        <form action="{{ route('shop') }}" method="GET">
                            <div class="search-input-wrapper">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" class="search-input" placeholder="Search for products...">
                                <button type="submit" class="search-btn">Search</button>
                            </div>
                        </form>
                        <div class="search-suggestions mt-4">
                            <h6>Popular Searches</h6>
                            <div class="suggestion-tags">
                                <a href="#">Headphones</a>
                                <a href="#">Smart Watch</a>
                                <a href="#">Sneakers</a>
                                <a href="#">Backpack</a>
                                <a href="#">Laptop</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

@stack('scripts')
</body>
</html>
