@extends('_layout.master-content')



@section('content')
    <div class="col-12">
        <h3 class="text-center">Geçici Barınma Alanları</h1>
        <h5 class="text-center mb-3">
            Bu sayfada, içerisinde belirtilenler hariç tüm yerler telefonla doğrulanmıştır. Ancak günler, hatta saatler
            içerisinde bu bilgiler değişebildiğinden dolayı, kendi araştırmanızı yapmanız önemle rica edilir.
        </h3>
        <div class="card" id="button-for-filter">
            <div class="card-body">
                <div class="row">

                    @foreach ($geciciBarinma as $data)
                        <div class="col col-2 mt-4">
                            <a class="btn btn-primary btn-block" data-city={{ $data['name_tr'] }}>{{ $data['name_tr'] }}</a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        @foreach ($geciciBarinma as $data)
            <div class="gcity card mt-3 p3" id='city-{{ $data['name_tr'] }}'  >
                <div class="card-body">
                    <h2>{{ $data['name_tr'] }}</h2>
                    <div class="row">
                        @foreach ($data['value_tr']['data']['items'] as $value)
                            <div class="col-3 mt-3">

                                <h4>
                                    {{ $value['name'] }}
                                </h4>
                                @if ($value['address'] ?? '')
                                    <a href="{{ $value['address'] }}" target="_blank">Google Maps</a> <br>
                                @endif
                                @if ($value['url'] ?? '')
                                    <a href="{{ $value['url'] ?? '' }}" target="_blank">Twitter</a>
                                @endif
                                
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection


@section('js_vendor')
    <script>
        $(document).ready(function() {
            $('.gcity').hide('slow');
            $('.btn-primary').click(function() {
                var city = $(this).data('city');
                $('.gcity').hide('slow');
                $('#city-' + city).show('slow');
            })
        })
    </script>
@endsection
