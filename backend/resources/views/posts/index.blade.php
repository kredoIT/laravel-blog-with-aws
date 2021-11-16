@extends('layouts.app')

@section('title', 'Index')

@section('content')

@if ($posts->isNotEmpty())
	@foreach($posts as $post)
		<div class="row mt-2 border border-2 rounded p-3 px-4">
			<div class="col-12">
				<h5>
					<a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
				</h5>
				<p>
					{{ $post->body }}
				</p>
				
				@if ($post->user_id === Auth::user()->id)
				<form class="float-end" method="post" action="{{ route('post.destroy', $post->id) }}">
					@csrf
					@method('DELETE')

					<!-- edit !-->
					<a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>

					<button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
				</form>
				@endif
			</div>
		</div>
	@endforeach
@endif

@endsection