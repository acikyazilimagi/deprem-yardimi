<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/theia-sticky-sidebar/js/ResizeSensor.min.js')}}"></script>
<script src="{{asset('assets/vendor/theia-sticky-sidebar/js/theia-sticky-sidebar.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('js_vendor')

<script src="{{ ('/assets/js/scripts.js') }}"></script>

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

<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
@livewireScripts

@yield('js_page')
@stack('js')
