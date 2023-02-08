<!-- Header -->
<header class="main-header sticky">
  <a href="#menu" class="btn-mobile">
    <div class="hamburger hamburger--spin" id="hamburger">
      <div class="hamburger-box">
        <div class="hamburger-inner"></div>
      </div>
    </div>
  </a>
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-6 h-full d-flex align-items-center">
          <h6>
            <a href="/">depremyardim.com</a>
          </h6>
      </div>
      <div class="col-lg-9 col-6">
        <!-- Menu -->
        <nav id="menu" class="main-menu">
          <ul>
            <li>
              <span><a href="#">Afet Bilgi <i class="fa fa-chevron-down"></i></a></span>
              <ul>
                <li><a class="text-dark" href="{{route('icerik.gecici-barinma-alanlari')}}">Geçiçi Barınma Alanları</a></li>
                <li><a class="text-dark" href="{{route('icerik.guvenli-toplanma-alanlari')}}">Güvenli Toplanma Alanları</a></li>
              </ul>
            </li>
            {{-- <li>
              <span><a href="#">Try Demos <i class="fa fa-chevron-down"></i></a></span>
              <ul>
                <li><a href="index.html">HTML email - download link</a></li>
                <li><a href="html-email-attached-file.html">HTML email - attached file</a></li>
                <li><a href="simple-mail-download-link.html">Simple mail - download link</a></li>
                <li><a href="phpmailer-attached-file.html">PHP mailer - attached file</a></li>
                <li><a href="phpmailer-download-link.html">PHP mailer - download link</a></li>
              </ul>
            </li>
            <li>
              <span><a href="#">How HTML email looks like <i class="fa fa-chevron-down"></i></a></span>
              <ul>										
                <li><a href="php/phpmailer/email-file-download.html" target="_blank">File download link</a></li>
                <li><a href="php/phpmailer/email-file-attachment.html" target="_blank">File attachment</a></li>
                <li><a href="php/phpmailer/email-confirmation.html" target="_blank">Confirmation</a></li>
              </ul>
            </li>
          </ul>
          <li>
            <ul>
              <li><a class="text-dark p-0 m-0" href="{{route('icerik.gecici-barinma-alanlari')}}">Geçiçi Barınma Alanları</a></li>
              <li><a class="text-dark p-0 m-0" href="{{route('icerik.guvenli-toplanma-alanlari')}}">Güvenli Toplanma Alanları</a></li>
            </ul>
          </li> --}}
        </nav> 
        <!-- Menu End -->
      </div>
    </div>
  </div>
</header>
<!-- Header End -->