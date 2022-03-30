<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $categories = Category::all();
        return view('admin.posts.create', compact('post', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:posts|min:5|max:50',
            'content' => 'required|string',
            'image' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id' //<Controllo che esista dentro la tab. Categories nella colonna dell'id
        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.min' => 'La lunghezza minima del titolo è di 5 caratteri.',
            'title.max' => 'La lunghezza massima del titolo è di 50 caratteri.',
            'title.unique' => "Esiste gia' un post dal titolo ''$request->title''.",
            'content.required' => 'Scrivi qualcosa nel post.',
            'image.url' => 'Url immagine non valido.',
            'category_id.exists' => 'Categoria non valida.'
        ]);

        $data = $request->all();
        $post = new Post();
        $data['slug'] = Str::slug($request->title, '-'); //<vedi alternativa dopo fill
        $post->fill($data);
        //< $post->slug = Str::slug($post->title, '-'); e poi levo slug dalla $fillable di Model Post
        $post->save();

        return redirect()->route('admin.posts.index')->with('message', "Post creato con successo")->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|unique:posts|min:5|max:50',
            'content' => 'required|string',
            'image' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id' //<Controllo che esista dentro la tab. Categories nella colonna dell'id

        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.min' => 'La lunghezza minima del titolo è di 5 caratteri.',
            'title.max' => 'La lunghezza massima del titolo è di 50 caratteri.',
            'title.unique' => "Esiste gia' un post dal titolo ''$request->title''.",
            'content.required' => 'Scrivi qualcosa nel post.',
            'image.url' => 'Url immagine non valido.',
            'category_id.exists' => 'Categoria non valida.'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title, '-');
        $post->update($data);
        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('message', "Il tuo post ''$post->title'' è stato eliminato")->with('type', 'danger');
    }
}
