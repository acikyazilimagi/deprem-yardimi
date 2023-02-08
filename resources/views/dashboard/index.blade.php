@extends("_layout.master")

@section('js_page')
    <script>
        $(document).ready(function () {
            $(document).on('change', '#city', function () {
                const city = $(this).val();
                $.ajax({
                    url: "{{route('get_district')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        city: city
                    },
                    success: function (data) {
                        $('#district').empty();
                        $('#district').append('<option value="">İlçe Seçiniz</option>');
                        $.each(data.data, function (key, value) {
                            $('#district').append('<option value="' + value.district + '">' + value.district + '</option>');
                        });

                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
            $(document).on('change', '#district', function () {
                const district = $(this).val();
                $.ajax({
                    url: "{{route('get_street')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        district: district
                    },
                    success: function (data) {
                        $('#street').empty();
                        $('#street').append('<option value="">Mahalle Seçiniz</option>');
                        $.each(data.data, function (key, value) {
                            $('#street').append('<option value="' + value.street + '">' + value.street + '</option>');
                        });

                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endsection

@section('content-side')
    <div class="col-12">
        <div class="alert alert-info">Lütfen kayıt eklemeden önce <a class="badge badge-info p-2 font-weight-bold text-white" style="font-size: 12px" href="{{ route('fast_search') }}">Yardım İsteyenler</a> sayfasından aynı kaydın daha önce eklenip eklenmediğini kontrol ediniz.</div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <livewire:address-notification-form/>
            </div>
        </div>
    </div>
@endsection

@section('content-full')
    <div class="col-12">
        <a href="{{route('fast_search')}}" class="btn btn-success mt-3 d-block text-white">Yardım İsteyenler</a>
    </div>
@endsection
