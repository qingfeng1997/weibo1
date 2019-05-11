@extends('layouts.default')

@section('title','所有用户')

@section('content')
<div class="offset-md-2 col-md-8">
  <h2 class="mb-4 text-center">所有用户</h2>
  <div class="list-group list-group-flush">
    @foreach ($users as $user)
      <div class="list-group-item">
        <img class="mr-3" src="{{ $user->gravatar() }}" alt="{{ $user->name }}" width=32>
        <a href="{{ route('users.show', $user) }}">
          {{ $user->name }}
        </a>
	@can('destroy',$user)
   	     <form action="{{ route('users.destroy', $user->id) }}" method="post" class="float-right">
      		    {{ csrf_field() }}
      		    {{ method_field('DELETE') }}
      		    <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
    	     </form>
	@endcan
      </div>
    @endforeach
  </div>

  <div class="mt-3">
      {!! $users->render()  !!}
  </div>

</div>
@stop
