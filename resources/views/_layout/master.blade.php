<!DOCTYPE html>
<html lang="tr">
    @include('_layout.head')

    <body>
        <div id="preloader">
            <div data-loader="circle-side"></div>
        </div>
        <div id="page">
            @include('_layout.header')
            <main>
                <div class="contact">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8" id="mainContent">
                                <div class="row">
                                    @yield('content-side')
                                </div>
                            </div>
                            <div class="col-lg-4" id="sidebar">
                                @include('_layout.sidebar')
                            </div>
                        </div>
                        <div class="row">
                            @yield('content-full')
                        </div>
                    </div>
                </div>
            </main>
            @include('_layout.footer')
        </div>
        @include('_layout.javascript')
    </body>
</html>
