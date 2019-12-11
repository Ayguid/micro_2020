@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
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
                  <a href="{{Route('admin.roles.show', $role->id)}}">{{$role->name}}</a>
                @endif
              <br>
            @endforeach



          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
