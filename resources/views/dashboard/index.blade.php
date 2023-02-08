@extends("_layout.master")

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

<style>
#datatable{
    margin: 15px 0 !important;
}

#source::placeholder{
    color: #cc6161 !important;
}
</style>
@endsection

@section('js_vendor')
<script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
@endsection

@section('js_page')
<script>
  $(document).ready(function() {
    $(document).on('change', '#city', function(){
      const city = $(this).val();
      $.ajax({
        url: "{{route('get_district')}}",
        type: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          city: city
        },
        success: function(data) {
          $('#district').empty();
            $('#district').append('<option value="">İlçe Seçiniz</option>');
          $.each(data.data, function(key, value) {
            $('#district').append('<option value="'+value.district+'">'+value.district+'</option>');
          });

        },
        error: function(err) {
          console.log(err);
        }
      });
    });
    $(document).on('change', '#district', function(){
      const district = $(this).val();
      $.ajax({
        url: "{{route('get_street')}}",
        type: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          district: district
        },
        success: function(data) {
          $('#street').empty();
            $('#street').append('<option value="">Mahalle Seçiniz</option>');
          $.each(data.data, function(key, value) {
            $('#street').append('<option value="'+value.street+'">'+value.street+'</option>');
          });

        },
        error: function(err) {
          console.log(err);
        }
      });
    });

    $('#datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{route('dashboard.datatable')}}",
      columns: [
        {data: 'city'},
        {data: 'address'},
        {data: 'address_detail'},
        {data: 'fullname'},
      ],
        search: {
            return: true,
        },
    });

/*
    $('.form_submit').on('click', function (e){
        e.preventDefault()
        const data = $(this).closest('form').serialize();

        // TODO : 422 response dönünce swal ile mesaj verilmeli

        $.ajax({
            url: '{{ route('dashboard.store') }}',
            data: data,
            type: 'POST',
            success: function (res) {
                Swal.fire({
                    position: 'top-end',
                    icon: res.data.status,
                    title: res.data.title,
                    html: res.data.message,
                    showConfirmButton: false,
                    timer: 2500
                })
                $('#form_reset').click()

                $('#city').val(null).trigger('change');
                $('#district').val(null).trigger('change');
                $('#street').val(null).trigger('change');
            },
            error: function (res) {
                Swal.fire({
                    position: 'top-end',
                    icon: res.data.status,
                    title: res.data.title,
                    body: res.data.message,
                    showConfirmButton: false,
                    timer: 2500
                })
            },
        })

    })
*/
  });
</script>
@endsection

@section('content-side')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <livewire:address-notification-form/>
            </div>
        </div>
    </div>
@endsection

@section('content-full')
      <div class="col-12 mt-4">
          <div class="card">
              <div class="card-body">
                  <table id="datatable" class="table table-responsive table-striped table-bordered" style="width:100%">
                      <thead>
                      <tr>
                          <th>İl/İlçe/Mahalle</th>
                          <th>Adres Bilgisi</th>
                          <th>Adres Tarifi</th>
                          <th>Ad Soyad</th>
                      </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
              </div>
          </div>
      </div>
@endsection
