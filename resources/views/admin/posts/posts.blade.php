{{-- As configurações do arquivo app, se extende para esse arquivo --}}
@extends('admin.layouts.app')

@section('title', 'Listagem dos Posts')


{{-- Utilizando conteúdo dinâmico. --}}
@section('content')
    <a href="{{ route('posts.create') }}">Criar novo post</a>
    <hr>

    {{-- Verificando se existe uma session flash (sessão temporária). Caso exista, seu valor é impresso para o  usuário. --}}
    @if (session('message'))
        <div style="color: green">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('posts.search') }}" method="post">
        @csrf
        <input type="text" name="search" placeholder="O que deseja filtrar?">
        <button type="submit">Filtrar</button>
    </form>

    <h1>Posts</h1>

    @foreach ($posts as $post)
        <p>
            <img src="{{ url("storage/{$post->image}") }}" alt="{{ $post->title }}" style="max-width: 150px;">
            {{ $post->title }}
            [
            <a href="{{ route('posts.show', $post->id) }}">Ver detalhes</a> |
            <a href="{{ route('posts.edit', $post->id) }}">Editar post</a>
            ]
        </p>
    @endforeach

    <hr>

    {{-- Realizando a paginação dos registros recebidos do controller. appends() permite que passe um array com todos os parâmetros que será utilizado na páginação. 
    Caso a variável $filters esteja setada, ela é usada na paginação, caso não, a paginação acontece sem ela. --}}
    @if (isset($filters))
        {{ $posts->appends($filters)->links() }}
    @else
        {{ $posts->links() }}
    @endif
@endsection
