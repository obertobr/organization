<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Tag;

class ItemController extends Controller
{
    public readonly Item $item;

    public function __construct() {
        $this->item = new Item();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->item->all();
        return view('items', ['items' => $items]);
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
            'imagem' => 'nullable|string',
            'fk_item' => 'nullable|exists:items,id',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
        ]);

        $item = Item::create($validatedData);

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
