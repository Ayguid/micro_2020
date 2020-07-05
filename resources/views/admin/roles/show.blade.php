@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">User: </div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif
            @if(session('alert-success'))
              <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> <strong>{!! session('alert-success') !!}</strong></div>
            @endif
            @if(session('alert-danger'))
              <div class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> <strong>{!! session('alert-danger') !!}</strong></div>
            @endif


            <h2>{{$data['role']->name}}</h2>
            <form method="POST" action="{{route('admin.roles.update', $data['role']->id)}}">
              @csrf
              <div class="form-group form-check">
                @foreach ($data['permissions'] as $permission)
                  <input {{!$data['edit']?'disabled':''}} {{$data['role']->hasPermissionTo($permission->name)?'checked':''}} name="permissions[]" type="checkbox" class="form-check-input" id="exampleCheck1" value="{{$permission->id}}">
                  <label class="form-check-label" for="permissions">  {{$permission->name}}</label><br>
                @endforeach
              </div>
              
              @if ($data['edit'])
              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Save') }}
                  </button>
                </div>
              </div>
            @endif
            </form>

            @if (!$data['edit'])
            <a class="btn btn-primary" href="{{route('admin.roles.edit', $data['role']->id)}}">Edit</a>
          @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
