@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

<form method="post" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data">
	@csrf
	@method('PATCH')

	<div class="mb-3">
		<label for="title" class="form-label">Title</label>
		<input 
			name="title" 
			type="text" 
			class="form-control" 
			id="title" 
			value="{{ old('title', $post->title) }}"
			placeholder="Write title here ..." 
		/>
		@error('title')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>
	<div class="mb-3">
		<label for="body" class="form-label">Body</label>
		<textarea 
			name="body" 
			class="form-control" 
			rows="5"
			placeholder="Write something here ..."
		>{{ old('body', $post->body) }} </textarea>
		@error('body')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>

	<div class="mb-3">
		<div class="col-6">
			<img src="{{ App\Models\Post::showImage($post->image) }}" class="img-thumbnail mb-3" alt="{{ $post->image }}" />
			<input name="image" class="form-control" type="file" id="image"/>
		</div>
		@error('image')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>

	<button type="submit" class="btn btn-primary">Save</button>
</form>

@endsection