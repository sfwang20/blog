@extends('layouts.app')

@section('page-title')
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-uppercase">Blog Single</h4>
                <ol class="breadcrumb">
                    <li><a href="/">Home</a>
                    </li>
                    <li class="active"><a href="/posts/admin">Blog Admin Panel</a>
                    </li>
                    <li class="active">Blog Single</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="page-content">
  <div class="container">
    <h1> {{ $post->title}} </h1>
    @if (isset($post->category))
    <small class="d-block text-muted">{{ $post->category->name }}</small>
    @endif
    <small class="d-block text-muted">{{ $post->tagsString()}}</small>
    <small class="author">{{ $post->user->name }}</small>
    <div class="toolbox">
      <a href="/posts/{{ $post->id }}/edit" class="btn btn-primary">Edit</a>
      <button class="btn btn-danger" onclick="deletePost({{ $post->id }})">Delete</button>
    </div>
    @if (!$post->thumbnail)
      <div class="text-danger">no thumbnail</div>
    @else
    <img width="640" src="{{ $post->thumbnail }}" alt="thumbnail">
    @endif
    <div class="content">
      {{ $post->content }}
    </div>
  </div>
</div>
@endsection

<form id="delete-form" action="/posts/id" method="post">
  <input type="hidden" name="_method" value="delete">
  @csrf
</form>
