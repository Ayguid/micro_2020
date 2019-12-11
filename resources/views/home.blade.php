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

                    You are logged in


                    @role('superadmin|admin')
                    <br>
                    <br>
                    <a class="btn btn-primary" href="{{route('admin.cats')}}">Categories</a>
                    @endrole

                    @role('superadmin')
                    <br>
                    <br>
                    <a class="btn btn-primary" href="{{route('admin.roles')}}">Roles</a>
                    @endrole



                    @can('index users')
                      <br>
                      <br>
                      <a class="btn btn-primary" href="{{route('admin.users')}}">Users</a>
                    @endcan




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
