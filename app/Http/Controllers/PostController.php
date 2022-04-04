<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
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

    // StoreUpdatePost é um objeto que realizar as validações dos campos.
    public function store(StoreUpdatePost $request)
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

        // Ao finalizar a inserção dos dados, o usuário é redirecionado para a página principal.
        return redirect()->route('posts.index');
    }

    public function show($id)
    {
        /* 
        Capturando o post pelo seu ID, através da model 'Post'. where() verifica se o valor da coluna 
        'id', é igual ao valor da variável $id.
        
        $post = Post::where('id', $id)->first();
        */

        // O método find() recupera um item diretamente pelo seu ID. Caso o valor de $post seja null, ou seja, nenhum post encontrado, o usuário é redirecionado para a página principal.
        if (!$post = Post::find($id)) {
            return redirect()->route('posts.index');
        }


        return view('admin.posts.show', compact('post'));
    }

    public function destroy($id)
    {
        if (!$post = Post::find($id))
            return redirect()->route('posts.index');

        // Excluindo o registro de um post do banco.
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('message', 'Post deletado com sucesso!'); // Messagem para o usuário através de uma session flash (sessão temporária).
    }
}
