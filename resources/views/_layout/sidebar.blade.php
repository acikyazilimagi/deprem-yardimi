<div id="contactInfoContainer" class="theiaStickySidebar">
    <div class="contact-box">
        <i class="icon icon-phone-call2"></i>
        <h2 class="text-danger" style="font-size: 25px"><strong>184'ü arayın ve <br> 2 -> 2 -> 1 <br> tuşlarına basın</strong></h2>
        <h2>AFAD Numaraları</h2>
        <table class="table table-bordered table-striped table-sm mb-0">
            <tbody>
                <tr>
                    <td class="text-right pr-3">Adana </td>
                    <td>
                        <a href="tel:+903222272854">0 322 227 28 54</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Adıyaman </td>
                    <td>
                        <a href="tel:+904162161231">0 416 216 12 31</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Diyarbakır </td>
                    <td>
                        <a href="tel:+904123261156">0 412 326 11 56</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Gaziantep </td>
                    <td>
                        <a href="tel:+903424281118">0 342 428 11 18</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Hatay </td>
                    <td>
                        <a href="tel:+903261120000">0 326 112 00 00</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Kahramanmaraş </td>
                    <td>
                        <a href="tel:+903442214991">0 344 221 49 91</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Kilis </td>
                    <td>
                        <a href="tel:+903488134478">0 348 813 44 78</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Malatya </td>
                    <td>
                        <a href="tel:+904223242898">0 422 324 28 98</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Mardin </td>
                    <td>
                        <a href="tel:+904822123740">0 482 212 37 40</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Osmaniye </td>
                    <td>
                        <a href="tel:+903288252080">0 328 825 20 80</a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right pr-3">Şanlıurfa </td>
                    <td>
                        <a href="tel:+904143137290">0 414 313 72 90</a>
                    </td>
                </tr>
            </tbody>
        </table>
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
