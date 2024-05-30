@extends('master')

@section('content')
<main>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/item.css')}}">

    <script src="{{ asset('assets/js/global.js')}}" defer></script>
    <script src="{{ asset('assets/js/item.js')}}" defer></script>
    <div id="modal" style="display: none;">
        <div id="addItem">
            <p>Adicionar item</p>
            <input id="searchModal" type="text" />
            <div id="itemsModal">
            </div>
        </div>
    </div>
    <p id="name">{{$item->nome}}</p>
    <div id="main">
        <div>
            <img id="image" src="{{asset(str_replace('public', 'storage', $item->imagem))}}" alt="Image preview">
        </div>
        <div>
            <p>Tags:</p>
            <input id="tagsInput" name="tags" value="{{$tags}}" type="text" readonly />
            @if ($item->parentItem)
                <p>Local:</p>
                <a id="local" href="{{route('items.show',['item' => $item->parentItem->id])}}">
                    <img src="{{asset(str_replace('public', 'storage', $item->parentItem->imagem))}}" />
                    <p>{{$item->parentItem->nome}}</p>
                </a>
            @endif
        </div>
    </div>
    <p>Descrição:</p>
    <textarea id="description" name="descricao" onload="adjustTextareaHeight(this)" readonly>{{$item->descricao}}</textarea>

    <p>Itens:</p>
    <div id="childItems">
        @foreach ($item->childItems as $childItem)
            <a class="childItem" href="{{route('items.show',['item' => $childItem->id])}}">
                <img src="{{asset(str_replace('public', 'storage', $childItem->imagem))}}" />
                <p>{{$childItem->nome}}</p>
            </a>
        @endforeach
        <div id="add" class="add childItem">
            <img src="{{asset('assets/imgs/plus.svg')}}" />
            <p>Adicionar item</p>
        </div>
    </div>

    <div id="return">
        <a href="{{route('items.index')}}">VOLTAR</a>
        <a href="{{route('items.edit',['item' => $item->id])}}">
            <img src="{{asset('assets/imgs/edit.svg')}}">
        </a>
    </div>
</main>

@endsection
