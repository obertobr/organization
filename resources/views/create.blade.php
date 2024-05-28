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
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="main">
            <div>
                <p>Imagem:</p>
                <div class="upload-area" id="upload-area">
                    <span id="upload-text">Clique<br>ou<br>arraste uma imagem</span>
                    <input type="file" id="file-input" name="imagem" hidden>
                    <div class="image-preview" id="image-preview" style="display: none;">
                        <img id="preview-image" src="" alt="Image preview">
                        <button type="button" id="remove-button" hidden>&times;</button>
                    </div>
                </div>
            </div>
            <div>
                <p>Nome:</p>
                <input type="text" name="nome"/>
                <p>Tags:</p>
                <input id="tagsInput" name="tags" type="text" />
            </div>
        </div>
        <p>Descrição:</p>
        <textarea id="description" name="descricao" oninput="adjustTextareaHeight(this)"></textarea>

        <p>Local:</p>
        <div id="local">
            <div>
                <img id="localImg" src="/storage/images/A0uwy3IL6zkrDSQMxCYOZLlrycfwhqwGESgx6yM2.jpg"/>
                <p id="localName">Gaveta</p>
                <button id="localRemove" type="button">&times;</button>
            </div>
            <p>Você pode selecionar um local para esse item</p>
            <input id="fk_item" name="fk_item" type="hidden" />
        </div>

        <input type="submit" value="SALVAR" id="save"/>
    </form>
</main>

@endsection
