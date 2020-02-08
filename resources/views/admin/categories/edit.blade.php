@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <a class="btn btn-primary" href="{{route('admin.cats.show', $category->id)}}">{{$category->title_es}}</a>
        <div class="card">
          <div class="card-header">Categoria: </div>

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





            <form class="" action="{{route('admin.cats.update', $category->id)}}" method="post">
            {{-- <form class="" action="#" method="post"> --}}
              {{ csrf_field() }}


              <div class="row">
                @foreach ($category->getFillable() as $fKey => $fValue)
                  @foreach ($category->getAttributes() as $aKey => $aValue)


                    @if ($aKey == $fValue && $aKey!=='parent_id')
                      <div class="form-group col-md-4">
                        <label for="">{{$fValue}}</label>
                        <input class="form-control{{ $errors->has($fValue) ? ' is-invalid' : '' }}" type="text" name="{{$aKey}}" value="{{$aValue}}">
                        @if ($errors->has($fValue))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first($fValue) }}</strong>
                          </span>
                        @endif
                      </div>
                    @endif
                  @endforeach
                @endforeach
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" name="button" class="btn btn-primary">
                    Guardar cambios en categoria
                  </button>
                </div>
              </div>

            </form>




                  </div>
                </div>
              </div>
            </div>
          </div>
        @endsection
