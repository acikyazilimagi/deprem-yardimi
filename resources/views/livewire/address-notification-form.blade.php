<form wire:submit.prevent="submit">
    @csrf
    <div class="row">
        <div class="col-12">
            <h3>Adres Bildirim Formu (1 Kişi Giriniz)</h3>
            <p>Yardıma ihtiyacı olan kişi/kişilerin adres bilgisini giriniz.</p>
        </div>
        @php
            $cities = $this->getCities();
            $districts = $this->getDistricts();
            $neighbourhoods = $this->getNeighbourhoods();
        @endphp
        <div class="col-md-6">
            <div class="form-group">
                <label for="city">Şehir (Zorunlu)</label>
                <input @class(['is-invalid' => $errors->has('city')]) type="text" placeholder="İl Seçiniz" wire:model.lazy="city" x-data="select({
                    options: @js($cities)
                })">
                @error('city')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="district">İlçe (Zorunlu)</label>
                <input @class(['is-invalid' => $errors->has('district')]) type="text" placeholder="İlçe Seçiniz" wire:model.lazy="district" x-data="select({
                    options: @js($districts)
                })">
                @error('district')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="street">Mahalle (Zorunlu)</label>
                <input @class(['is-invalid' => $errors->has('neighbourhood')]) type="text" placeholder="Mahalle Seçiniz" wire:model="neighbourhood" x-data="select({
                    options: @js($neighbourhoods)
                })">
                @error('neighbourhood')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="source">Bilgi Kaynağı (Zorunlu)</label>
                <input @class(['form-control', 'is-invalid' => $errors->has('source')]) wire:model.defer="source" placeholder="Bilginin Kaynağını Giriniz (Zorunlu)" type="text"/>
                @error('source')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="street2">Sokak (Zorunlu)</label>
                <input @class(['form-control', 'is-invalid' => $errors->has('street')]) wire:model.defer="street" placeholder="Sokak Adını Giriniz." type="text"/>
                @error('street')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="apartment">Apartman (Zorunlu)</label>
                <input @class(['form-control', 'is-invalid' => $errors->has('apartment')]) wire:model.defer="apartment" placeholder="Apartman veya Bina Adı Giriniz." type="text"/>
                @error('apartment')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="apartment_no">Bina Dış Kapı No</label>
                <input class="form-control" wire:model.defer="apartmentNo" placeholder="Bina Dışa Kapı No. Giriniz." type="text"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="apartment_floor">Bulunan Kat</label>
                <input class="form-control" wire:model.defer="floor" placeholder="Bulunan Kat Sayısını Giriniz." type="text" id="address_form_floor"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="fullname">Ad ve Soyad</label>
                <input class="form-control" wire:model.defer="nameSurname" placeholder="Ad ve Soyad Giriniz (Zorunlu Değil)" type="text"/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Telefon No</label>
                <input class="form-control" wire:model.defer="phoneNumber" placeholder="0 555 555 55 55 Şeklinde Giriniz.." type="tel" name="phone" id="address_form_phone" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="address">Adres Tarifi</label>
                <input class="form-control" wire:model="directions" placeholder="Bulunan Konumu Tarif Etmek İsterseniz Buraya Giriniz" type="text"/>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-0">
                <label for="aydinlatma_metni"><input type="checkbox" id="aydinlatma_metni" required> Aydınlatma Metni'ni okudum ve kabul ediyorum</label>
            </div>
            <div class="text-danger font-weight-bold mb-3">Enkaz, yıkım, yardım ve destek ihtiyaçları konusunda verdiğim bilgilerin doğru ve teyit edilmiş olduğunu, bilgi kirliliği ve yanlış uygulamalara yol açmamak için gerekli tüm önlem ve tedbirleri aldığımı, vermiş olduğum bilgilerde meydana gelen değişiklik ve güncellemeleri bildireceğimi kabul ve beyan ederim. </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-3 order-1 order-md-0">
                    <button wire:click="clearForm" type="button" name="submit" class="btn btn-block btn-danger">
                        <span class="btn-form-func-content">Temizle</span>
                    </button>
                </div>
                <div class="col-12 col-md-9 order-0 order-md-1 mb-3">
                    <button type="submit" name="submit" data-type="save" class="form_submit btn btn-block btn-info">
                        <span class="btn-form-func-content">Kaydet</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@pushonce('js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('select', ({options}) => ({
                options,
                init() {
                    new TomSelect(this.$el, {
                        options: this.options,
                        preload: true,
                        maxItems: 1
                    });
                }
            }))
        })

        window.addEventListener('formSubmitted', ({detail}) => {
            Swal.fire({
                position: 'top-end',
                icon: detail.status,
                title: detail.title,
                html: detail.message,
                showConfirmButton: false,
                timer: 2500
            })
        })
    </script>
@endpushonce
