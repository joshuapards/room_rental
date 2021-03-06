@extends('layouts.app')

@section('title') My Posts @endsection

@section('content')
@include('includes.navin')
<div class="container">
	@if($posts->isEmpty())
		<h3>No Post to Show</h3>
		<a href="{{ route('addpost') }}" class="btn btn-link">Create Post</a>
	@endif
	@include('includes.showerror')
	@include('includes.showsuccess')
	@include('includes.showerrors')
	<div class="row"> 
		@foreach($posts as $post)
		<div class="col-md-3">
			<img src="/uploads/posts/default.jpg" alt="{{ $post->title }}" class="img-posts" /> 
			{{ $post->title }}
			<br/>
			{{ $post->type }}
			<br/>
			{{ $post->price }}
			<br/>
			{{ $post->location }}
			<br/>
			{{ $post->description }}
			<br/>
			<a href="{{ route('edit-post',$post->id) }}"><button class="btn btn-primary btn-xs">Update</button></a>
			<a href="{{ route('delete-post', $post->id) }}"><button class="btn btn-danger btn-xs">Delete</button></a>
		</div>
		@endforeach
	</div>
	<div class="center-div">
		{{ $posts->links() }}
	</div>
</div>
@endsection