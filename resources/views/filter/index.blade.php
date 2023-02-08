@extends("_layout.master-content")

@section('js_page')
    <script type="text/javascript">
        function getToken() {
            $.ajax({
                url: "{{route('get-token')}}",
                type: "GET",
                success: function (data, status, xhr) {
                    const token = xhr.getResponseHeader('X-AUTH-KEY')
                    $('#token').val(token)
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }

        $(function () {
            getToken()

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

                $.ajax({
                    url: "{{ route('filter.filter') }}?X-AUTH-KEY=" + token,
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

                        getToken()

                        $('#filter_table > tbody').html('')

                        if(data.data.length){
                            data.data.forEach(item => {
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
                        }else{
                            $('#filter_table > tbody').append(
                                '<tr>' +
                                '    <td colspan="5">Herhangi bir veri bulunamadı !</td>' +
                                '</tr>'
                            )
                        }
                    },
                    error: function (err) {
                        $($this).removeAttr('disabled')
                        getToken()
                        console.log(err);
                    }
                });

            })
        })
    </script>
@endsection

@section('content')
    <input type="hidden" id="token">
    <div class="container">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">İl (Zorunlu)</label>
                                <select id="city" class="form-control" name="city" required>
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
                </div>
            </div>
        </div>
    </div>
@endsection


