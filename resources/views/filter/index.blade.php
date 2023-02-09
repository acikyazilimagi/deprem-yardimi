@extends("_layout.master-content")

@section('js_page')
    <script type="text/javascript">
        function getToken() {
            $.ajax({
                url: "{{route('security.get-token')}}",
                type: "GET",
                success: function (data, status, xhr) {
                    const token = xhr.getResponseHeader('X-AUTH-KEY')
                    $('#token').val(token)
                },
                error: function (err) {}
            });
        }

        $(function () {
            getToken()

            $(document).on('change', '#city', function () {
                $('#filter_table > tbody').html('')

                const city = $(this).val();
                const token = $('#token').val()

                $.ajax({
                    url: "{{route('location.districts')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        city,
                        'X-AUTH-KEY': token
                    },
                    success: function (data) {
                        $('#district').empty();
                        $('#district').append('<option value="">İlçe Seçiniz</option>');
                        $.each(data.data, function (key, value) {
                            $('#district').append('<option value="' + value.district + '">' + value.district + '</option>');
                        });
                        getToken()
                    },
                    error: function (err) {
                        getToken()
                    }
                });
            });
            $(document).on('change', '#district', function () {
                $('#filter_table > tbody').html('')

                const district = $(this).val();
                const token = $('#token').val()

                $.ajax({
                    url: "{{route('location.streets')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        district,
                        'X-AUTH-KEY': token
                    },
                    success: function (data) {
                        $('#street').empty();
                        $('#street').append('<option value="">Mahalle Seçiniz</option>');
                        $.each(data.data, function (key, value) {
                            $('#street').append('<option value="' + value.street + '">' + value.street + '</option>');
                        });
                        getToken()
                    },
                    error: function (err) {
                        getToken()
                    }
                });
            });

            $('#search').on('click', function (e){
                e.preventDefault()

                const $this = this

                const city = $('#city').val()
                const district = $('#district').val()
                const street = $('#street').val()
                const keyword = $('#keyword').val()
                const token = $('#token').val()

                if(!(city.length && district.length)){
                    alert("İl ve İlçe seçmeden arama yapamazsınız !")
                    return false
                }

                $($this).attr('disabled', 'disabled')

                let current_page = parseInt($('#more').attr('data-current-page'));
                let last_page = parseInt($('#more').attr('data-last-page'));

                let querystring = ''
                if(current_page !== 0 && current_page !== last_page){
                    current_page++
                    querystring = '&page=' + current_page
                }

                $.ajax({
                    url: "{{ route('filter.filter') }}?X-AUTH-KEY=" + token + querystring,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        city,
                        district,
                        street,
                        keyword,
                    },
                    success: function (data) {
                        $($this).removeAttr('disabled')
                        $('#more').removeAttr('disabled').html('Devamını Getir')

                        getToken()

                        if(data.data.data.length){
                            data.data.data.forEach(item => {
                                $('#filter_table > tbody').append(
                                    '<tr>' +
                                    '    <td>' + item.city.toString() + '/' + item.district.toString() + '/' + item.street.toString() + ' <br /> Oluşturulma : ' + item.created_at + '</td>' +
                                    '    <td>' + item.street2 + '/' + item.apartment + '/' + item.apartment_no + '/' + item.apartment_floor  + '</td>' +
                                    '    <td>' + item.address + '</td>' +
                                    '    <td>' + item.fullname + '</td>' +
                                    '    <td>' + item.source + '</td>' +
                                    '</tr>'
                                )
                            })

                            if(data.data.current_page === data.data.last_page){
                                $('#more')
                                    .removeClass('d-block').addClass('d-none')
                                    .attr('data-current-page', 0)
                                    .attr('data-last-page', 0)
                            }else{
                                $('#more')
                                    .removeClass('d-none').addClass('d-block')
                                    .attr('data-current-page', data.data.current_page)
                                    .attr('data-last-page', data.data.last_page)
                            }
                        }else{
                            $('#filter_table > tbody').append(
                                '<tr>' +
                                '    <td colspan="5">Herhangi bir veri bulunamadı !</td>' +
                                '</tr>'
                            )
                        }
                    },
                    error: function (err) {
                        $('#more').removeAttr('disabled').html('Devamını Getir')
                        $($this).removeAttr('disabled')
                        getToken()
                    }
                });

            })

            $('#more').on('click', function (e) {
                $(this).attr('disabled', 'disabled').html('Yükleniyor..')

                e.preventDefault()
                $('#search').trigger('click')
            })

            setTimeout(function (){
                @if(!empty($filter_city))
                    $('#city').trigger('change');
                @endif
            }, 1500)
        })
    </script>
@endsection

@section('content')
    <input type="hidden" id="token">
    <div class="container">
        <div class="col-12 mb-3">
         @if(!empty($filter_city))
           <div class="alert alert-warning" role="alert">Lütfen <b>İlçe</b> seçiniz ve <b>Ara</b> butonuna tıklayınız.</div>
         @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">İl (Zorunlu)</label>
                                <select id="city" class="form-control" name="city" required>
                                    <option value="">İl Seçiniz.</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->city}}"
                                        {{ mb_strtolower($filter_city) === mb_strtolower($city->city) ?  'selected="selected"' : '' }}
                                        >{{$city->city}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="district">İlçe (Zorunlu)</label>
                                <select id="district" class="form-control" name="district" required>
                                    <option value="">İlçe Seçiniz.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="street" class="form-control" name="street" required>
                                    <option value="">Mahalle Seçiniz.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Herhangi bir kelime yazınız..">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" id="search" class="btn btn-success btn-block">Ara</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="alert alert-info text-center">Sayfa başına eleman sayısı 100 olarak belirlendi.</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="filter_table" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>İl/İlçe/Mahalle</th>
                                    <th>Adres Bilgisi</th>
                                    <th>Adres Tarifi</th>
                                    <th>Ad Soyad</th>
                                    <th>Kaynak</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button id="more" class="btn btn-success w-100 d-none" data-current-page="0" data-last-page="0">Devamını Getir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


