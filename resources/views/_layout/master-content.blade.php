<!DOCTYPE html>
<html lang="tr">
@include('_layout.head')
<body>

<!-- Preloader -->
<div id="preloader">
    <div data-loader="circle-side"></div>
</div>
<!-- Preloader End -->

<!-- Page -->
<div id="page">
    <!-- Header -->
    @include('_layout.header')
    <!-- Header End -->

    <!-- Sub Header -->
    @include('_layout.subheader')
    <!-- Sub Header End -->

    <!-- Main -->
    <main>
        <div class="contact">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
    <!-- Main End -->

    <!-- Footer -->
    @include('_layout.footer')
    <!-- Footer End -->
</div>
<!-- Page End -->

@include('_layout.javascript')

</body>

</html>
