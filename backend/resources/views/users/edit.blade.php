@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<form method="post" action="{{ route('user.update') }}" enctype="multipart/form-data">
	@csrf
	@method('PATCH')

	<div class="row">
		<div class="col-4">
			<div class="mb-3">
				@if ($user->avatar)
					<img src="{{ asset('/storage/avatars/' . $user->avatar) }}" class="img-thumbnail mb-3" alt="{{ $user->avatar }}" />
				@else
					<i class="far fa-image fa-9x"></i>
				@endif

				<input name="avatar" class="form-control" type="file" />
				@error('avatar')
					<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
				@enderror
				
			</div>
		</div>
	</div>

	<div class="mb-3">
		<label for="name" class="form-label">Name</label>
		<input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name', $user->name) }}"/>

		@error('name')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>
	<div class="mb-3">
		<label for="email" class="form-label">E-Mail Address</label>
		<input name="email" type="text" class="form-control" id="email" placeholder="E-Mail Address" value="{{ old('email', $user->email ) }}" />

		@error('email')
			<p class="text-danger">{{ $message }}</p>
		@enderror
	</div>

	<button type="submit" class="btn btn-primary">Save</button>

</form>

@endsection
