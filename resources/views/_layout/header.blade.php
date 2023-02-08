<style type="text/css">
    .hamburger-wrapper{
        display: none;
    }
    @media only screen and (max-width: 991px) {
        .hamburger-wrapper{
            display: block;
            margin-right: 10px;
        }
    }
</style>
<!-- Header -->
<header class="main-header sticky d-flex align-items-center" style="padding: 0;">
    <div class="container h-full">
        <div class="col-12 w-100 h-full d-flex align-items-center">
          <span class="hamburger-wrapper position-relative" style="width: 25px; height: 25px;">
              <a href="#menu" class="btn-mobile" style="top:0;left:0;">
              <div class="hamburger hamburger--spin" id="hamburger">
                  <div class="hamburger-box">
                      <div class="hamburger-inner"></div>
                  </div>
              </div>
          </a>
          </span>
            <h6 class="m-0">
                <a href="/">depremyardim.com</a>
            </h6>
            {{--      <div class="col-lg-9 col-6">--}}
            <!-- Menu -->
            {{-- <nav id="menu" class="main-menu">
              <ul>
                <li>
                  <span><a href="#">Try Demos <i class="fa fa-chevron-down"></i></a></span>
                  <ul>
                    <li><a href="index.html">HTML email - download link</a></li>
                    <li><a href="html-email-attached-file.html">HTML email - attached file</a></li>
                    <li><a href="simple-mail-download-link.html">Simple mail - download link</a></li>
                    <li><a href="phpmailer-attached-file.html">PHP mailer - attached file</a></li>
                    <li><a href="phpmailer-download-link.html">PHP mailer - download link</a></li>
                  </ul>
                </li> --}}
            {{-- <li>
              <span><a href="#">How HTML email looks like <i class="fa fa-chevron-down"></i></a></span>
              <ul>
                <li><a href="php/phpmailer/email-file-download.html" target="_blank">File download link</a></li>
                <li><a href="php/phpmailer/email-file-attachment.html" target="_blank">File attachment</a></li>
                <li><a href="php/phpmailer/email-confirmation.html" target="_blank">Confirmation</a></li>
              </ul>
            </li>								 --}}

            {{-- <li><a class="text-dark p-0 m-0" href="{{route('icerik.gecici-barinma-alanlari')}}">Geçiçi Barınma Alanları</a></li>

          </ul>
        </nav> --}}
            <!-- Menu End -->
            {{--      </div>--}}
        </div>
    </div>
</header>
<!-- Header End -->
