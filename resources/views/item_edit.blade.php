@extends('master')

@section('content')
<main>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/create.css')}}">

    <script src="{{ asset('assets/js/global.js')}}" defer></script>
    <script src="{{ asset('assets/js/register.js')}}" defer></script>
    <div id="modal" style="display: none;">
        <div id="addItem">
            <p>Adicionar item</p>
            <input id="searchModal" type="text" />
            <div id="itemsModal">
            </div>
        </div>
    </div>
    <form action="{{ route('items.update',['item' => $item->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div id="main">
            <div>
                <p>Imagem:</p>
                <div class="upload-area used" id="upload-area">
                    <span id="upload-text" hidden>Clique<br>ou<br>arraste uma imagem</span>
                    <input type="file" id="file-input" name="imagem" hidden>
                    <div class="image-preview" id="image-preview">
                        <img id="preview-image" src="{{asset(str_replace('public', 'storage', $item->imagem))}}" alt="Image preview">
                        <button type="button" id="remove-button">&times;</button>
                    </div>
                </div>
            </div>
            <div>
                <p>Nome:</p>
                <input type="text" name="nome" value="{{$item->nome}}"/>
                <p>Tags:</p>
                <input id="tagsInput" name="tags" type="text" value="{{$tags}}"/>
            </div>
        </div>
        <p>Descrição:</p>
        <textarea id="description" name="descricao" oninput="adjustTextareaHeight(this)">{{$item->descricao}}</textarea>

        <p>Local:</p>
        <div id="local" @if($item->fk_item) class="selected" @endif>
            <div>
                <img id="localImg" src="@if($item->fk_item) {{asset(str_replace('public', 'storage', $item->parentItem->imagem))}} @endif"/>
                <p id="localName">@if($item->fk_item) {{$item->parentItem->nome}} @endif</p>
                <button id="localRemove" type="button">&times;</button>
            </div>
            <p>Você pode selecionar um local para esse item</p>
            <input id="fk_item" name="fk_item" type="hidden" value="{{$item->fk_item}}"/>
        </div>

        <input type="submit" value="SALVAR" id="save"/>
    </form>
</main>

@endsection
