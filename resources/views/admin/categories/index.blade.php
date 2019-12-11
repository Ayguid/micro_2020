@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">

          <div class="card-header">Categories</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            {{-- {{$data}} --}}
            <div class="mb-2">
              <div class="row">
                @foreach ($data['categories'] as $cat)
                  <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-2">
                    <a href="{{route('admin.cats.show', $cat->id)}}" class="btn btn-primary btn-lg btn-block">{{$cat->title_es}}</a>
                    {{-- <a href="#" class="btn btn-primary btn-lg btn-block">{{$cat->title_es}}</a> --}}
                  </div>
                @endforeach
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
