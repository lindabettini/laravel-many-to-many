<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
//todo use Illuminate\Support\Facades\Auth; per isPublished
//todo use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


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
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.create', compact('post', 'tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {

        $request->validate([
            'title' => ['required', 'string', Rule::unique('posts')->ignore($post->id), 'min:5', 'max:50'],
            'content' => 'required|string',
            'image' => 'nullable|file',
            'category_id' => 'nullable|exists:categories,id', //<Controllo che esista dentro la tab. Categories nella colonna dell'id
            'tags' => 'nullable|exists:tags,id'
        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.min' => 'La lunghezza minima del titolo è di 5 caratteri.',
            'title.max' => 'La lunghezza massima del titolo è di 50 caratteri.',
            'title.unique' => "Esiste gia' un post dal titolo ''$request->title''.",
            'content.required' => 'Scrivi qualcosa nel post.',
            'image.file' => 'Seleziona un file immagine.',
            'category_id.exists' => 'Categoria non valida.',
            'tags.exists' => 'Uno dei tag selezionati non è valido'
        ]);

        $data = $request->all();
        $post = new Post();

        $post->fill($data);

        if (array_key_exists('image', $data)) {
            $img_url = Storage::put('post_images', $data['image']);
            $post->image = $img_url;
        }

        $post->slug = Str::slug($post->title, '-');

        $post->save();

        // Una volta creato il post, aggancio EVENTUALI tag
        if (array_key_exists('tags', $data)) $post->tags()->attach($data['tags']);

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
        $post_tags_ids = $post->tags->pluck('id')->toArray(); // Prendo gli id dei tag di questo post
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'tags', 'categories', 'post_tags_ids'));
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
            'title' => ['required', 'string', Rule::unique('posts')->ignore($post->id), 'min:5', 'max:50'],
            'content' => 'required|string',
            'image' => 'nullable|file',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id' //<Controllo che esista dentro la tab. Categories nella colonna dell'id

        ], [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.min' => 'La lunghezza minima del titolo è di 5 caratteri.',
            'title.max' => 'La lunghezza massima del titolo è di 50 caratteri.',
            'title.unique' => "Esiste gia' un post dal titolo ''$request->title''.",
            'content.required' => 'Scrivi qualcosa nel post.',
            'image.file' => 'Seleziona un file immagine.',
            'category_id.exists' => 'Categoria non valida.',
            'tags.exists' => 'Uno dei tag selezionati non è valido'
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
        if (count($post->tags)) $post->tags()->detach();
        $post->delete();
        return redirect()->route('admin.posts.index')->with('message', "Il tuo post ''$post->title'' è stato eliminato")->with('type', 'danger');
    }
}
