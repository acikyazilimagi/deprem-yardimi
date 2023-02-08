<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script async src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script async src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script async src="{{ asset('/assets/js/app.js') . '?t=' . mt_rand()  }}"></script>

@yield('js_vendor')

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
