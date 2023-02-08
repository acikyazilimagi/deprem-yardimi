<!DOCTYPE html>
<html lang="tr">
    @include('_layout.head')
    <body>
        <div id="preloader">
            <div data-loader="circle-side"></div>
        </div>
        <div id="page">
            @include('_layout.header')
            <main class="my-3">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </main>
            @include('_layout.footer')
        </div>
        @include('_layout.javascript')
    </body>
</html>
