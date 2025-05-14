<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    try {
        $Author = Author::all();
        return response()->json($Author);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener los Author', 'message' => $e->getMessage()], 500);
    }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request;
        
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:authors,email',
        'biografia' => 'nullable|string'
    ]);

    $author = Author::create($validated);

    return response()->json([
        'message' => 'Autor creado correctamente',
        'data' => $author
    ], 201);


    $author = Author::create($request->only(['nombre', 'email', 'biografia']));

    return response()->json($author->load('libros'), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    $author = Author::findOrFail($id);
    return response()->json($author);

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

    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:Author,email,' . $id,
        'biografia' => 'nullable|string',
    ]);

    $author = Author::findOrFail($id);
    $author->update($validated);

    return response()->json($author);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    try {
        $author = Author::findOrFail($id);
        $author->delete();
        return response()->json(['mensaje' => 'Author eliminado']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Author no encontrado', 'message' => $e->getMessage()], 404);
    }

    }
}
