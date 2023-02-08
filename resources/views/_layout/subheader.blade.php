<!-- Sub Header -->
<style type="text/css">
    .header-menu > li {
        font-size: 20px;
    }
    .nav-item-text{
        font-size: 20px;
        white-space: nowrap;
    }
    .sub-header {
        width: 100%;
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    .sub-header::-webkit-scrollbar {
        display: none;
    }
    @media screen  and (max-width: 768px) {
        .nav-item-text{
            font-size: 14px;
        }
        .header-menu > * + * {
            margin-left: 10px;
        }
    }
</style>

<div class="sub-header">
  <div class="container">
      <ul class="d-flex justify-content-between p-0 m-0 header-menu">
          <li><a href="{{route('dashboard')}}" class="nav-item-text text-white">Deprem Yardım Bildirimi</a></li>
          <li><a href="{{route('filter.index')}}" class="nav-item-text text-white">Detaylı Filtre</a></li>
      </ul>
  </div>
</div>
<!-- Sub Header End -->
