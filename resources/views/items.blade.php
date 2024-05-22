@extends('master')

@section('content')

<h1>Users</h1>

<ul>
    @foreach ($items as $item)
        <li>{{ $item->nome}}</li>
    @endforeach
</ul>

@endsection
