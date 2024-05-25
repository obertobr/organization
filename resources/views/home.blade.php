@extends('master')

@section('content')

<header>
    <input id="search" type="search" autocomplete="off" />
    <input id="filter" type="button" value="Filtros"/>
</header>
<div id="tags">
    <p>Tags</p>
    <hr>
    <div>
        <div>
            <input type="checkbox">
            <span>Eletronicos</span>
        </div>
        <div>
            <input type="checkbox">
            <span>Eletronicos</span>
        </div>
    </div>
</div>
<div id="items">
    <div class="item">
        <img src="http://127.0.0.1:8000/storage/images/yiWD08ImQroGgvgEvMygjUv9lP2HBhomEgx1Dk3C.jpg"/>
        <p>Gaveta</p>
    </div>
    <div class="item">
        <img src="http://127.0.0.1:8000/storage/images/yiWD08ImQroGgvgEvMygjUv9lP2HBhomEgx1Dk3C.jpg"/>
        <p>Gaveta</p>
    </div>
    <div class="item">
        <img src="http://127.0.0.1:8000/storage/images/yiWD08ImQroGgvgEvMygjUv9lP2HBhomEgx1Dk3C.jpg"/>
        <p>Gaveta</p>
    </div>
    <div class="item">
        <img src="http://127.0.0.1:8000/storage/images/yiWD08ImQroGgvgEvMygjUv9lP2HBhomEgx1Dk3C.jpg"/>
        <p>Gaveta</p>
    </div>
</div>

@endsection
