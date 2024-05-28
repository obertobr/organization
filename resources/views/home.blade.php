@extends('master')

@section('content')
<script src="{{ asset('assets/js/global.js')}}" defer></script>
<script src="{{ asset('assets/js/script.js')}}" defer></script>

<header>
    <input id="search" type="search" autocomplete="off" />
    <input id="filter" type="button" value="Filtros"/>
</header>
<div id="tags">
    <p>Tags</p>
    <hr>
    <div>
        @foreach ($tags as $tag)
            <div>
                <input type="checkbox" value="{{$tag->id}}">
                <span>{{$tag->nome}}</span>
            </div>
        @endforeach
    </div>
</div>
<div id="items">
</div>

@endsection
