@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
	@csrf
	<div class="mb-3">
		<label for="title" class="form-label">Title</label>
		<input 
			name="title" 
			type="text" 
			class="form-control" 
			id="title" 
			value="{{ old('title') }}"
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
		>{{ old('body') }} </textarea>
		@error('body')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>

	<div class="mb-3">
		<input name="image" class="form-control" type="file" id="image"/>
		@error('image')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>

	<button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection