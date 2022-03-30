@extends('layouts.app')

@section('content')
<header class="container">

  <div class="h1">{{ $post->title}}</div>
  <div>
    @if($post->category)
    <span class="badge rounded-pill @if($post->category) bg-{{$post->category->color}} @endif">@if($post->category){{ $post->category->label }}@endif</span>
    @endif
  </div>


</header>

<div class="clearfix">
  @if($post->image)
  <img src="{{$post->image}}" alt="{{ $post->slug }}" class="float-left mr-2">
  @endif
  <p>{{$post->content}}</p>
</div>
<time>{{ $post->created_at }}</time>
<hr>
<div class="d-flex align-items-center justify-content-end">
  <a href="{{route('admin.posts.edit', $post->id)}}" class="btn btn-warning mr-2"><i class="fa-solid fa-pencil mr-2"></i>Modifica</a>
  <form action="{{route('admin.posts.destroy', $post->id)}}" method="POST" class="delete-form">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger">Elimina</button>
  </form>

  <a href="{{route('admin.posts.index')}}" class="btn btn-secondary ml-2">
    <i class="fa-solid fa-arrow-left mr-2"></i></i>Indietro
  </a>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/delete-confirm.js')}}" defer></script>
@endsection