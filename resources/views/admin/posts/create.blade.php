<h1>Cadastrar novo post</h1>

{{-- Caso tenha algum erro, ele é exibido para o usuário. any() por default é false, caso true, indica que possui erros. --}}
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form action="{{ route('posts.store') }}" method="POST">
    @csrf {{-- Token para validação de formulário --}}

    {{-- old('') cria uma sessão temporária com o valor preenchido pelo usuário, que em casos de refresh da página, o valor não ser perdido. --}}
    <input type="text" name="title" id="title" placeholder="Título" value="{{ old('title') }}">
    <textarea name="content" id="content" cols="30" rows="4" placeholder="Conteúdo">{{ old('content') }}
    </textarea>
    <button type="submit">Enviar</button>
</form>
