<a href="{{ route('posts.create') }}">Criar novo post</a>
<hr>

{{-- Verificando se existe uma session flash (sessão temporária). Caso exista, seu valor é impresso para o  usuário. --}}
@if (session('message'))
    <div style="color: green">
        {{ session('message') }}
    </div>
@endif

<h1>Posts</h1>

@foreach ($posts as $post)
    <p>
        {{ $post->title }}
        [ <a href="{{ route('posts.show', $post->id) }}">Ver detalhes</a> ]
    </p>
@endforeach
