@extends("_layout.master")

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
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
          console.log(data);
          $('#street').empty();
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
      ]
    });

  });
</script>
@endsection

@section('content-side')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <h3>Adres Bildirim Formu (1 Kişi Giriniz)</h3>
                            <p>Yardıma ihtiyacı olan kişi/kişilerin adres bilgisini giriniz.</p>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
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
                                <select id="district" class="form-control select2" name="district" required>
                                    <option value="">İlçe Seçiniz.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="street" class="form-control select2" name="street" required>
                                    <option value="">Mahalle Seçiniz.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="apartment" class="form-control" name="street2" placeholder="Sokak Adını Giriniz." type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="apartment" class="form-control" name="apartment_name" placeholder="Apartman veya Bina Adı Giriniz." type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="apartment" class="form-control" name="apartment_no" placeholder="Bina Dışa Kapı No. Giriniz." type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="apartment" class="form-control" name="apartment_floor" placeholder="Bulunan Kat Sayısını Giriniz." type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="fullname" class="form-control" name="fullname" placeholder="Ad ve Soyad Giriniz (Zorunlu Değil)" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="phone" class="form-control" name="phone" placeholder="Telefon No. Giriniz (Zorunlu Değil)" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="source" class="form-control" name="source" placeholder="Bilginin Kaynağını Giriniz (Zorunlu)" type="text" required/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="source" class="form-control" name="address" placeholder="Bulunan Konumu Tarif Etmek İsterseniz Buraya Giriniz" type="text"/>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-block btn-info">
                                <span class="btn-form-func-content">Kaydet</span>
                                <span class="icon"><i class="fa fa-paper-plane" aria-hidden="true"></i></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content-full')
      <div class="col-12 mt-4">
          <div class="card">
              <div class="card-body">
                  <table id="datatable" class="table table-striped table-bordered" style="width:100%">
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
