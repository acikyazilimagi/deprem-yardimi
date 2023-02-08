<style type="text/css">
    .sub-header-menu > li {
        font-size: 20px;
    }
    .main-header .navbar-nav .nav-item {
        border-right: 1px solid #dedede;
    }
    .main-header .navbar-nav .nav-item:last-child {
        border-right: none;
    }
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary main-header">
    <div class="container-fluid">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://discord.gg/itdepremyardim" target="_blank">
                        <img src="https://afetharita.com/logo.svg" alt="IT Deprem Yardım Discord" width="24px">
                        <span>IT Deprem Yardım Discord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://deprem.io" target="_blank">
                        <img src="https://depremio.cdn.bubble.io/f1675704871606x367300328232597950/deprem-logo.svg" alt="Deprem.io" width="48px">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://afetharita.com" target="_blank">
                        <img src="https://afetharita.com/logo.svg" alt="AfetHarita.com" width="24px">
                        <span>AfetHarita.com</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="sub-header">
  <div class="container">
      <div class="row">
          <div class="col-12 d-flex justify-content-between sub-header-menu">
              <a href="{{route('dashboard')}}" class="btn btn-danger text-white">Deprem Yardım Bildirimi</a>
              <a href="{{route('fast_search')}}" class="btn btn-success ml-3 text-white">Yardım İsteyenler</a>
              <a href="{{route('filter.index')}}" class="btn btn-warning ml-3 text-white">Detaylı Filtre</a>
          </div>
      </div>
  </div>
</div>
