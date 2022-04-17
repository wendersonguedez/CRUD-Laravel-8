<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class PostController extends Controller
{
    public function posts()
    {
        /* Recuperando todos os registros do banco, através da model 'Post'
        $posts = Post::all();
        */

        // Recuperando todos os registros do banco e fazendo a paginação deles.
        $posts = Post::paginate();
        // $posts = Post::orderBy('id', 'DESC')->paginate(1);

        return view('admin.posts.posts', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    // StoreUpdatePost é um objeto que realiza as validações dos campos do banco.
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

        // Capturando todos os campos do banco com suas validações.
        $data = $request->all();

        // Verificando se o arquivo enviado pelo usuário é válido.
        if ($request->image->isValid()) {

            // Definindo um nome personalizado para o arquivo. O nome base vai ser o titulo do post, que concatena com sua extensão. 
            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();

            // Definindo o path de salvamento do arquivo. Por default aponta para storage/app/public
            $image = $request->image->storeAs('post', $nameFile);

            // Inserindo o path do arquivo no seu respectivo campo que foi definido na base de dados.
            $data['image'] = $image;
        }

        /* Inserindo todos os dados em seus respectivos campos na tabela. */
        Post::create($data);

        // Ao finalizar a inserção dos dados, o usuário é redirecionado para a página principal.
        return redirect()
            ->route('posts.index')
            ->with('message', 'Post criado com sucesso');
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
        // Se o usuário passar um post inexistente, ele é redirecionado para a página de listagem dos posts.
        if (!$post = Post::find($id))
            return redirect()->route('posts.index');

        // Caso exista um arquivo vinculado ao post, ele também será excluído.
        if (Storage::exists($post->image)) {
            Storage::delete($post->image);
        }

        // Excluindo o registro do post do banco.
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('message', 'Post deletado com sucesso!'); // Messagem para o usuário através de uma session flash (sessão temporária).
    }

    public function edit($id)
    {
        // Caso tente editar um post que não exista, o usuário é redirecionado para a mesma rota.
        if (!$post = Post::find($id))
            return redirect()->back();

        return view('admin.posts.edit', compact('post'));
    }

    // StoreUpdatePost é um objeto que realiza as validações dos campos do banco.
    public function update(StoreUpdatePost $request, $id)
    {
        // Caso o post não exista, o usuário é redirecionado para a paǵina anterior.
        if (!$post = Post::find($id))
            return redirect()->back();

        // $data armazena as validações de todos os campos do banco.
        $data = $request->all();

        // Verificando se o arquivo enviado pelo usuário é diferente de null e se é válido.
        if ($request->image && $request->image->isValid()) {
            // Caso já exista um arquivo salvo, ele é deletado e o novo arquivo é colocado em seu lugar.
            if (Storage::exists($post->image)) {
                Storage::delete($post->image);
            }

            // Definindo um nome personalizado para o arquivo. O nome base é o titulo do post + sua extensão. 
            $nameFile = Str::of($request->title)->slug('-') . '.' . $request->image->getClientOriginalExtension();

            // Definindo o path de salvamento do arquivo. Por default aponta para storage/app/public.
            // Nesse caso, dentro de storage/app/public, é criado um diretório de nome 'post'.
            $image = $request->image->storeAs('post', $nameFile);

            // Inserindo o path do arquivo no seu respectivo campo que foi definido na base de dados.
            $data['image'] = $image;
        }

        // Inserindo os dados no banco de dados, com todas as suas validações.
        $post->update($data);

        return redirect()
            ->route('posts.index')
            ->with('message', 'Post editado com sucesso!');
    }

    public function search(Request $request)
    {
        // Variável para não ter a perda do filtro ao paginar. except deixa de capturar os dados do campo que for passado.
        $filters = $request->except('_token');

        // O titulo e conteúdo dos posts são utilizados para realizar a filtragem. O valor digitado é capturado do campo de nome 'search'.
        $posts = Post::where('title', 'LIKE', "%{$request->search}%")
            ->orWhere('content', 'LIKE', "%{$request->search}%")
            ->paginate(1);


        return view('admin.posts.posts', compact('posts', 'filters'));
    }
}
