<div id="contactInfoContainer" class="theiaStickySidebar">
    <div class="contact-box">
        <i class="icon icon-phone-call2"></i>
        <h2 class="text-danger" style="font-size: 25px"><strong>184'ü arayın ve 2 -> 2 -> 1 tuşlarına basın</strong></h2>
        <h2>AFAD Numaraları</h2>
        <span class="font-weight-bold">Diyarbakır:</span> <a href="tel:+904123261156">0412 326 1156</a><br>
        <span class="font-weight-bold">Hatay:</span> <a href="tel:+903261120000">0326 112 0000</a><br>
        <span class="font-weight-bold">Maraş:</span> <a href="tel:+903442214991">0344 221 4991</a><br>
        <span class="font-weight-bold">Antep:</span> <a href="tel:+903424281118">0342 428 1118</a><br>
        <span class="font-weight-bold">Adana:</span> <a href="tel:+903222272854">0322 227 2854</a><br>
        <span class="font-weight-bold">Adıyaman:</span> <a href="tel:+904162161231">0416 216 1231</a><br>
        <span class="font-weight-bold">Urfa:</span> <a href="tel:+904143137290">0414 313 7290</a><br>
        <span class="font-weight-bold">Malatya:</span> <a href="tel:+904222128432">0422 212 8432</a><br>
        <span class="font-weight-bold">Mardin:</span> <a href="tel:+904822123740">0482 212 3740</a>
    </div>

    <div class="contact-box">
        <h2>Kayıtlı Yardım Talepleri</h2>
        <div style="gap: 5px;">
            @foreach($cityList as $cityName)
                <a class="btn btn-sm btn-outline-light mb-1 text-dark text-decoration-none"
                 href='{{route("filter.index", ['city' => $cityName?->city])}}' role="button">
                 {{ $cityName?->city }} ({{ $cityName?->countCityData() }})</a>
            @endforeach
        </div>
    </div>
</div>
