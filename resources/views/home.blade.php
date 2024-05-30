@extends('master')

@section('content')
<script src="{{ asset('assets/js/global.js')}}" defer></script>
<script src="{{ asset('assets/js/script.js')}}" defer></script>

<header>
    <input id="search" type="search" autocomplete="off" />
    <a id="create" href="{{ route('items.create')}}">
        <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px"><path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/></svg>
    </a>
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
