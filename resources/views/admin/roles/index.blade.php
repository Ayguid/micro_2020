@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <a href="{{route('home')}}" class="btn btn-primary col-2 mb-2">Home</a>
        <div class="card">
          <div class="card-header">Roles</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            @foreach ($data['roles'] as $role)
                @if ($role->name != 'god')
                  <div class="mb-2">
                    <a href="{{Route('admin.roles.show', $role->id)}}" >{{$role->name}}</a>
                  </div>
                @endif

            @endforeach

          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
