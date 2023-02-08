<head>
    <title>Deprem Yardım Bekleyen Çağrılar</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="depremyardim.com">
    <meta name="description" content="Depremde göçük altında kalan insanların ve yakınlarının yardım çağrıları toplanıyor. Deprem illeri: Kahramanmaraş, Hatay, Gaziantep, Şanlıurfa, Malatya, Osmaniye, Adana, Kilis, Adıyaman, Diyarbakır">
    <meta name="keywords" content="deprem,yardım,yardim,cagri,göçük,gocuk,kahramanmaraş,kahramanmaras,maraş,maras,hatay,diyarbakır,diyarbakir,adıyaman,adiyaman,kilis,osmaniye,malatya,şanlıurfa,sanlıurfa,urfa,gaziantep,antep,adana,ailem,bebek,çocuk,bina,yıkıldı,afad,kurtarma">

    <link rel=canonical href="{{ route('dashboard') }}" />

    <link rel="icon" href="{{ asset('/assets/img/favicon/favicon.ico') }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('dashboard') }}" >
    <meta property="og:title" content="Deprem Yardım Çağrısı ve Arama Kurtarma">
    <meta property="og:description" content="Depremde göçük altında kalan insanların ve yakınlarının yardım çağrıları toplanıyor.">
    <meta property="og:image" content="{{ asset('/assets/img/image.png') }}" >

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Deprem Yardım Çağrısı ve Arama Kurtarma">
    <meta name="twitter:description" content="Depremde göçük altında kalan insanların ve yakınlarının yardım çağrıları toplanıyor.">
    <meta name="twitter:image" content="{{ asset('/assets/img/image.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Wruczek/Bootstrap-Cookie-Alert@gh-pages/cookiealert.css">
    <link href="{{ asset('assets/css/app.css') . '?t=' . mt_rand() }}" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.2.2/css/tom-select.min.css" integrity="sha512-BrNXB6PRnf32ZqstFiYQT/L7aVZ45FGojXbBx8nybK/NBhxFQPHsr36jH11I2YoUaA5UFqTRF14xt3VVMWfCOg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/1.4.0/css/tom-select.bootstrap4.min.css" integrity="sha512-bsZe9NfO80YYujMHauw1VLoVb6Puee7/jD7E0nErUMQTTEjNecSyVwEfu4556S/D9c+5AMKglW349bxoSUrucA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9X26M290K8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-9X26M290K8');
    </script>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "NGO"
    }
    </script>

    @yield('css')

    @livewireStyles

{{--    @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
</head>
