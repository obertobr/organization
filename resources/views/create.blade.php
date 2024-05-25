@extends('master')

@section('content')
<div class="container">
    <h1>Create Item</h1>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nome">Item Name</label>
            <input type="text" name="nome" class="form-control" id="nome" required>
        </div>

        <div class="form-group">
            <label for="descricao">Description</label>
            <textarea name="descricao" class="form-control" id="descricao" required></textarea>
        </div>

        <div>
            <label for="imagem">Imagem:</label>
            <input type="file" name="imagem" id="imagem" required>
        </div>

        <div class="form-group">
            <label for="fk_item">Parent Item</label>
            <select name="fk_item" class="form-control" id="fk_item">
                <option value="">None</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" name="tags[]" class="form-control" id="tagss" placeholder="Enter tags, separated by commas">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
