<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts= Post::paginate(6);
        $categories = Category::all();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validazione dati
        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);
        
        $data = $request->all();

        $newPost = new Post;

        $newPost->fill($data);

        //creiamo uno slug con il nuovo titolo
        $slug = Str::slug($data['title'], '-');

        //creo una variabile che restituirà true or false se c'è già uno slug uguale a quello appena creato
        $slug_presente = Post::where('slug', $slug)->first();
        
        $i = 1;//counter

        //finchè slug_presente è uguale a true
        while($slug_presente){

            // aggiungiamo allo slug di prima il counter
            $slug = $slug . '-' . $i;

            //verifichiamo se lo slug esiste ancora
            $slug_presente = Post::where('slug', $slug)->first();

            //incrementiamo il counter
            $i++;
        }

        //assegno allo slug del nuovo post lo slug corretto
        $newPost->slug = $slug;

        $newPost->save();

        // all'interno di $newPost->tags "attacco"/"inserisco" l'array dei tags che arrivano dalla pagina create (name="tags[]") in $data (che prende i dati grazie al request->all())); lo faccio dopo il save perchè l'attach prende il dato dalla tabella posts
        if(array_key_exists('tags', $data)){ //se l'array tags è presente in $data salva i dati nella tabella ponte, altrimenti va direttamente alle righe successive
        // potrei anche scrivere if(isset($data['tags])){}
            $newPost->tags()->attach($data['tags']);
        }
        
        return redirect()->route('admin.posts.show', $newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //validazione dati
        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $data = $request->all();

        //il titolo nuovo è diverso da quello vecchio?
        if($data['title'] != $post->title){

            //se sì
            //creiamo uno slug con il nuovo titolo
            $slug = Str::slug($data['title'], '-'); 

            //creo una variabile che restituirà true or false se c'è già uno slug uguale a quello appena creato
            $slug_presente = Post::where('slug', $slug)->first();

            $i = 1; //contatore

            //finchè slug_presente è uguale a true
            while($slug_presente){

                // aggiungiamo allo slug di prima il counter
                $slug = $slug . '-' . $i;

                //verifichiamo se lo slug esiste ancora
                $slug_presente = Post::where('slug', $slug)->first();

                //incrementiamo il counter
                $i++;
            }
            
            //assegno al data slug il nuovo slug creato
            $data['slug'] = $slug;
        }

        $post->update($data);

        if(array_key_exists('tags', $data)){
            $post->tags()->sync($data['tags']);
        }

        return redirect()->route('admin.posts.index',)->with('update', 'Hai modificato il post ' . $post->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        $post->tags()->detach();

        return redirect()->route('admin.posts.index')->with('delete', 'Hai eliminato il post ' . $post->title);
    }
}
