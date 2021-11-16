@extends('layouts.app')

@section('title', 'Show')

@section('content')

<form method="post" action="{{ route('comment.store', $post->id) }}" class="mb-5">
	@csrf 
	<div class="row">
		<div class="col-12 border border-1 rounded mb-2">
			<div class="p-2 mt-1">
				<h5>{{ $post->title }}</h5>
				<p>
					{{ $post->body }}
				</p>
				<div class="mt-2">
					<img src="{{ App\Models\Post::showImage($post->image)  }}" class="img-thumbnail mb-3" alt="{{ $post->image }}" />
				</div>
			</div>
		</div>
		
		@error('comment')
			<div class="text-danger">{{ $message }}</div>
		@enderror
		<input type="text" name="comment" class="form-control" id="comment" placeholder="Write your comment here" value="{{ old('comment') }}" />

		<div class="text-end ms-3">
			<button type="submit" class="btn btn-primary btn-sm mt-2">Submit</button>
		</div>

	</div>
</form>

@if ($comments->isNotEmpty())

	@foreach ($comments as $comment)
		<div class="row mt-2 border border-1 rounded">
			<div class="col-10 pt-2 px-2 mb-2">
				<strong>{{ $comment->user->name }}</strong>
				
				<span class="ms-3 mt-2">{{ $comment->body }}</span>
			</div>

			@if ($comment->user_id === Auth::user()->id)
				<div class="col-2 text-end">
					<form method="post" action="{{ route('comment.destroy', $comment->id) }}">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger btn-sm mt-1 mb-1">
							<i class="fas fa-trash-alt"></i> Delete
						</button>
					</form>
				</div>
			@endif
		</div>
	@endforeach

@endif

@endsection