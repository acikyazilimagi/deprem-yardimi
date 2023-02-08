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
    function getToken() {
        $.ajax({
            url: "{{route('get-token')}}",
            type: "GET",
            success: function(data, status, xhr) {
                const token = xhr.getResponseHeader('X-AUTH-KEY')
                $('#token').val(token)
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

  $(document).ready(function() {
      getToken()

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
        {data: 'maps_link', 'fnCreatedCell': function (nTd, sData, oData, iRow, iCol) {
            if(oData.maps_link){
                $(nTd).html("<a href='"+oData.maps_link+"' target='_blank'>"+oData.maps_link+"</a>");
            }
        }},
        {data: 'fullname'},
      ],
        search: {
            return: true,
        },
    });

    $('.form_submit').on('click', function (e){
        e.preventDefault()
        const data = $(this).closest('form').serialize();

        $('#form-save').attr('disabled', 'disabled')

        // TODO : 422 response dönünce swal ile mesaj verilmeli
        // TODO : buton disable olmalı

        $.ajax({
            url: '{{ route('dashboard.store') }}',
            data: data,
            type: 'POST',
            headers: {
                "X-AUTH-KEY": $('#token').val()
            },
            success: function (res) {
                getToken()
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

                $('#form-save').removeAttr('disabled')
            },
            error: function (res) {
                getToken()
                $('#form-save').removeAttr('disabled')
                Swal.fire({
                    position: 'top-end',
                    icon: res.data.status,
                    title: res.data.title,
                    body: res.data.message,
                    showConfirmButton: false,
                    timer: 2500
                })
            }
        })

    })



  });
</script>
@endsection

@section('content-side')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.store') }}" method="post" onsubmit="return false">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <h3>Adres Bildirim Formu (1 Kişi Giriniz)</h3>
                            <p>Yardıma ihtiyacı olan kişi/kişilerin adres bilgisini giriniz.</p>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Şehir (Zorunlu)</label>
                                <select id="city" class="form-control select2" name="city" required>
                                    <option value="">İl Seçiniz.</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->city}}">{{$city->city}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="district">İlçe (Zorunlu)</label>
                                <select id="district" class="form-control select2" name="district" required>
                                    <option value="">İlçe Seçiniz.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="street">Mahalle (Zorunlu)</label>
                                <select id="street" class="form-control select2" name="street" required>
                                    <option value="">Mahalle Seçiniz.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="source">Bilgi Kaynağı (Zorunlu)</label>
                                <input id="source" class="form-control" name="source" placeholder="Bilginin Kaynağını Giriniz (Zorunlu)" type="text" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="street2">Sokak (Zorunlu)</label>
                                <input id="street2" class="form-control" name="street2" placeholder="Sokak Adını Giriniz. (Zorunlu)" type="text" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apartment">Apartman (Zorunlu)</label>
                                <input id="apartment" class="form-control" name="apartment" placeholder="Apartman veya Bina Adı Giriniz." type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apartment_no">Bina Dış Kapı No</label>
                                <input id="apartment_no" class="form-control" name="apartment_no" placeholder="Bina Dışa Kapı No. Giriniz." type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apartment_floor">Bulunan Kat</label>
                                <input id="apartment_floor" class="form-control" name="apartment_floor" placeholder="Bulunan Kat Sayısını Giriniz." type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fullname">Ad ve Soyad</label>
                                <input id="fullname" class="form-control" name="fullname" placeholder="Ad ve Soyad Giriniz (Zorunlu Değil)" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telefon No</label>
                                <input id="phone" class="form-control" name="phone" placeholder="Telefon No. Giriniz (Zorunlu Değil)" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Adres Tarifi</label>
                                <input id="address" class="form-control" name="address" placeholder="Bulunan Konumu Tarif Etmek İsterseniz Buraya Giriniz" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Google Maps Linki</label>
                                <input id="address" class="form-control" name="maps_link" placeholder="Konuma Ait Google Maps Linki" type="text"/>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <button type="reset" name="submit" id="form_reset" class="btn btn-block btn-danger">
                                        <span class="btn-form-func-content">Temizle</span>
                                        <span class="icon"><i class="fa fa-trash-alt" aria-hidden="true"></i></span>
                                    </button>
                                </div>
                                <div class="col-12 col-md-9">
                                    <button type="button" name="submit" id="form-save" class="form_submit btn btn-block btn-info">
                                        <span class="btn-form-func-content">Kaydet</span>
                                        <span class="icon"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="token" value="" id="token">
                </form>
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
                          <th>Link</th>
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
