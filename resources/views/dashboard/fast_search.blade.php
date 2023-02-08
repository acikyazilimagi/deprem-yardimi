@extends("_layout.master-content")

@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <style>
        #datatable {
            margin: 15px 0 !important;
        }

        #source::placeholder {
            color: #cc6161 !important;
        }
    </style>
@endsection

@section('js_vendor')
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
@endsection

@section('js_page')
    <script>
        $(document).ready(function () {
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
                                if(/https?/.test(oData.maps_link)){
                                    $(nTd).html("<a class='text-danger' href='"+oData.maps_link+"' target='_blank'>Haritaya Git</a>");
                                }else{
                                    let link = 'https://www.google.com/maps/place/' + oData.street + ',' + oData.district + '/' + oData.city_raw
                                    $(nTd).html("<a class='text-danger' href='"+link+"' target='_blank'>Haritaya Git</a>");
                                }
                            }
                        }},
                    {data: 'fullname'},
                ],
                search: {
                    return: true,
                },
                language: {
                    "sDecimal": ",",
                    "sEmptyTable": "Tabloda herhangi bir veri mevcut değil",
                    "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                    "sInfoEmpty": "Kayıt yok",
                    "sInfoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
                    "sInfoThousands": ".",
                    "sLengthMenu": "Sayfada _MENU_ kayıt göster",
                    "sLoadingRecords": "Yükleniyor...",
                    "sProcessing": "İşleniyor...",
                    "sSearch": "Ara:",
                    "sZeroRecords": "Eşleşen kayıt bulunamadı",
                    "oPaginate": {
                        "sFirst": "İlk",
                        "sLast": "Son",
                        "sNext": "Sonraki",
                        "sPrevious": "Önceki"
                    },
                    "oAria": {
                        "sSortAscending": ": artan sütun sıralamasını aktifleştir",
                        "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                    },
                    "select": {
                        "rows": {
                            "_": "%d kayıt seçildi",
                            "0": "",
                            "1": "1 kayıt seçildi"
                        }
                    }
                },
            });
        });
    </script>
@endsection

@section('content')
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered w-100">
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
    </div>
@endsection
