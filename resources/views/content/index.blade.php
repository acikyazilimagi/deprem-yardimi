@extends("_layout.master-content")

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

<style>
#datatable{
    margin: 15px 0 !important;
}

#source::placeholder{
    color: #cc6161 !important;
}
</style>
@endsection

 
 

@section('content')
<div class="container">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    @foreach($menus as $menu)
                        
                    <div class="col col-6 mt-3">
                        <a href="/icerik/{{$menu['slug']}}" class="btn btn-primary btn-block">{{$menu['name']}}</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

 
