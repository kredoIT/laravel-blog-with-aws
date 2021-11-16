@extends('layouts.app')

@section('title', 'Show Profile')

@section('content')

<div class="row">
	<div class="col-3">
		@if ($user->avatar)
			<img src="{{ App\Models\User::showAvatar($user->avatar) }}" class="img-thumbnail mb-2" alt="{{ $user->avatar }}" />
		@else
			<i class="far fa-image fa-9x"></i>
		@endif
	</div>
	<div class="col-6" style="margin-top: auto!important;">
		<div class="row">
			<div class="col-12 mt-2">
				<span class="fw-bold fs-5">{{ $user->name }}</span>
				<a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm btn-block mb-2 ms-3">Edit Profile</a>
			</div>
		</div>		
	</div>
</div>

@if ($posts->isNotEmpty())
<ul class="list-group">
	@foreach($posts as $post)
	<li class="list-group-item">
		<h6>{{ $post->title }}</h6>
		<p class="fw-light">{{ $post->body }}</p>
	</li>
	@endforeach
</ul>
@endif

@endsection
