<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Item;
use App\Models\Tag;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return view('home', compact('tags'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $tagsSelected = $request->input('tags');

        $query = Item::orderBy('nome');

        if(!empty($tagsSelected)){
            $query->whereHas('tags', function($query) use ($tagsSelected) {
                $query->whereIn('tags.id', $tagsSelected);
            });
        }

        $query->where('nome', 'like', '%'.$searchTerm.'%');

        $results = $query->select('id', 'nome', 'imagem')->get();

        return response()->json($results);
    }

    public function tags()
    {
        $tags = Tag::query()->select('nome')->get();
        return response()->json($tags);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $tags = Tag::all();
        return view('create', compact('items', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fk_item' => 'nullable|exists:items,id',
            'tags' => 'nullable|string',
        ]);

        // Salvar a imagem
        $path = $request->file('imagem')->store('public/images');

        // Salvar o item
        $item = new Item();
        $item->nome = $request->nome;
        $item->descricao = $request->descricao;
        $item->fk_item = $request->fk_item;
        $item->imagem = $path;
        $item->save();

        $tags = json_decode($validatedData["tags"], true);

        if (!empty($tags)) {
            $tags = array_column($tags, 'value');

            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['nome' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $item->tags()->sync($tagIds);
        }

        return redirect()->route('items.index')->with('success', 'Item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $tags = $item->tags->pluck('nome')->implode(',');
        $item->load('parentItem', 'childItems');
        return view('item', compact('item', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $tags = $item->tags->pluck('nome')->implode(',');
        $item->load('parentItem');
        return view('item_edit', compact('item', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fk_item' => 'nullable|exists:items,id',
            'tags' => 'nullable|string',
        ]);

        if ($request->hasFile('imagem')) {
            Storage::delete($item->imagem);

            $imagePath = $request->file('imagem')->store('public/images');
            $item->imagem = $imagePath;
        }

        $item->nome = $request->nome;
        $item->descricao = $request->descricao;
        $item->fk_item = $request->fk_item;

        $item->save();

        $tags = json_decode($validatedData["tags"], true);

        if (!empty($tags)) {
            $tags = array_column($tags, 'value');

            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['nome' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $item->tags()->sync($tagIds);
        } else {
            $item->tags()->sync([]);
        }

        $unusedTags = Tag::whereDoesntHave('items')->get();
        foreach ($unusedTags as $tag) {
            $tag->delete();
        }

        return redirect()->route('items.show', $item);
    }

    public function updatelocal(Request $request, Item $item)
    {
        $fkitem = $request->input('fk_item');

        $item->fk_item = $fkitem;
        $item->save();

        return response()->json(['message' => 'Item updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        Storage::delete($item->imagem);

        $item->delete();

        $unusedTags = Tag::whereDoesntHave('items')->get();
        foreach ($unusedTags as $tag) {
            $tag->delete();
        }

        return redirect()->route('items.index');
    }
}
