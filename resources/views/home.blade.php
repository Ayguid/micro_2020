@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h5 class="mb-4">You are logged in</h5>
                    <div class="mb-2">
                      <a class="btn btn-primary" href="{{route('indexMyData')}}">Mis datos</a>
                    </div>


                    @role('superadmin|admin')
                    <div class="mb-2">
                      <a class="btn btn-primary" href="{{route('admin.cats')}}">Categories</a>
                    </div>
                    @endrole

                    @role('superadmin')
                    <div class="mb-2">
                      <a class="btn btn-primary" href="{{route('admin.fileManager')}}">Media Manager</a>
                    </div>
                    <div class="mb-2">
                      <a class="btn btn-primary" href="{{route('admin.roles')}}">Roles</a>
                    </div>
                    @endrole



                    @can('index users')
                      <div class="mb-2">
                        <a class="btn btn-primary" href="{{route('admin.users')}}">Users</a>
                      </div>
                    @endcan




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
