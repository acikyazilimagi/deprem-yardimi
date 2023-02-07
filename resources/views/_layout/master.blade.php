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
			<!-- Contact  -->
			<div class="contact">
				<div class="container">
					<!-- Form -->
          <div class="row">
            <div class="col-lg-8" id="mainContent">
              @yield('content')
            </div>
            <div class="col-lg-4" id="sidebar">
              <!-- Contact Info Container -->
              @include('_layout.sidebar')
              <!-- Contact Info Container End -->
            </div>
          </div>
					<!-- Form End -->
				</div>
			</div>
			<!-- Contact End -->
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
