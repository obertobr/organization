<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $query = Item::query();

        if(!empty($tagsSelected)){
            $query->whereHas('tags', function($query) use ($tagsSelected) {
                $query->whereIn('tags.id', $tagsSelected);
            });
        }

        $query->where('nome', 'like', '%'.$searchTerm.'%');

        $results = $query->select('id', 'nome', 'imagem')->get();

        return response()->json($results);
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
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
        ]);

        // Salvar a imagem
        $path = $request->file('imagem')->store('public/images');

        // Salvar o item
        $item = new Item();
        $item->nome = $request->nome;
        $item->descricao = $request->descricao;
        $item->imagem = $path;
        $item->save();

        if (!empty($validatedData['tags'])) {
            $tagIds = [];
            foreach ($validatedData['tags'] as $tagName) {
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
