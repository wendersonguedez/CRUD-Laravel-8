<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function posts()
    {
        // Recuperando todos os registros do banco, através da model 'Post'
        $posts = Post::all();

        return view('admin.posts.posts', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        /*
        Capturando todos os registros que foram enviados pelo formulário.
        $request->all();

        Capturando um registro especifico que foi enviado pelo formulário.
        $request->title;
        */

        /* Inserindo os dados enviados pelo formulário em cada campo da tabela do banco. 'Post' é minha model. 
        Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);
        */

        /* Inserindo todos os dados automaticamente em seus respectivos campos da tabela. */
        Post::create($request->all());

        return redirect()->route('posts.index');
    }
}
