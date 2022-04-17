{{-- Caso tenha algum erro, ele é exibido para o usuário. any() por default é false, caso true, indica que possui erros. --}}
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

{{-- Token para validação de formulário --}}
@csrf
<input type="file" name="image" id="image">


{{-- value="{{ $post->title }}" captura o valor desse campo diretamento do banco. 
caso ele não exista, é colocado o valor default que vem da função old(), faz uma sessão temporária e o usuário não perde o valor que havia sido preenchido por ele. --}}
<input type="text" name="title" id="title" placeholder="Título" value="{{ $post->title ?? old('title') }}">
<textarea name="content" id="content" cols="30" rows="4" placeholder="Conteúdo">
    {{ $post->content ?? old('content') }}
</textarea>
<button type="submit">Enviar</button>
