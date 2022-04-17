@extends('admin.layouts.app')

@section('title', "Editar o Post: {$post->title}")

@section('content')
    <h1>Editar o post <strong>{{ $post->title }}</strong></h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        {{-- Indicando de forma oculta qual o método de envio desse formulário. --}}
        @method('put')
        @include('admin.posts._partials.form')
    </form>

@endsection
