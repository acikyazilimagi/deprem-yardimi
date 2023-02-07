<!-- Back to top button -->
<div id="toTop"><i class="fa fa-chevron-up"></i></div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Vendor Javascript Files -->
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/easing/js/easing.min.js')}}"></script>
<script src="{{asset('assets/vendor/parsley/js/parsley.min.js')}}"></script>
<script src="{{asset('assets/vendor/theia-sticky-sidebar/js/ResizeSensor.min.js')}}"></script>
<script src="{{asset('assets/vendor/theia-sticky-sidebar/js/theia-sticky-sidebar.min.js')}}"></script>
<script src="{{asset('assets/vendor/mmenu/js/mmenu.min.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/js/filepond-plugin-file-validate-size.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/js/filepond-plugin-file-validate-type.js')}}"></script>
<script src="{{asset('assets/vendor/filepond/js/filepond.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('js_vendor')

<!-- Main Javascript File -->
<script src="{{ ('assets/js/scripts.js') }}"></script>
<script src="{{ ('assets/js/index.js') }}"></script>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('.select2').select2({
      theme: 'bootstrap-5'
    });
  });
</script>

<script>
  @if(Session::has('success'))
    Swal.fire({
      position: 'top-end',
      icon: "success",
      title: "{{Session::get('success.title')}}",
      showConfirmButton: false,
      timer: 2500
    })
  @elseif(Session::has('error'))
    Swal.fire({
      position: 'top-end',
      icon: "error",
      title: "{{Session::get('error.title')}}",
      showConfirmButton: false,
      timer: 2500
    })
  @endif
</script>
@yield('js_page')
