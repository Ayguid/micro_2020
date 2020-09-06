@extends('layouts.app')

@section('content')

  <div class="container">
    @if(Session::has('alert-success'))
      <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> <strong>{!! session('alert-success') !!}</strong></div>
    @endif
    @if(Session::has('alert-danger'))
      <div class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> <strong>{!! session('alert-danger') !!}</strong></div>
    @endif

    @if ($errors->count()>0)
      <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $err)
          <strong>{{$err}}</strong>
        @endforeach
      </div>
    @endif

    {{-- index  --}}

    <form class="mb-2" action="{{route('admin.translations.find')}}" method="post">
      {{ csrf_field() }}
      <input autofocus class="form-control" type="text" name="queryString" value="" placeholder="Buscar Palabra o frase">
      <button type="submit" name="button" class="btn btn-primary">
        Buscar
      </button>
    </form>

    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      Agregar Traduccion
    </button>

    @isset($translations)
      <form class="mt-2" action="{{route('admin.translations.save')}}" method="post">
        {{ csrf_field() }}


        <div id="collapseExample" class="form-group row collapse">

         <div class="col-md-6">
           {{-- <label for="Atributo">Agregar Traduccion</label> --}}
           <input autofocus class="form-control" type="text" name="newTranslation[word]" value="" placeholder="Palabra o frase">
           <input autofocus class="form-control" type="text" name="newTranslation[en]" value="" placeholder="Ingles">
           <input autofocus class="form-control" type="text" name="newTranslation[pt]" value="" placeholder="Portugues">
         </div>

        </div>

    <div class="form-group row">
      @foreach ($translations['en'] as $key => $data)
         <div class="col-md-6">
           <label for="Atributo">{{$key}}</label>
           <input autofocus class="form-control" type="text" name="{{$key}}[en]" value="{{$data}}" placeholder="Ingles">
           <input autofocus class="form-control" type="text" name="{{$key}}[pt]" value="{{$translations['pt'][$key]}}" placeholder="Portugues">
         </div>
      @endforeach
    </div>

      <div class="form-group row">
        <div class="col-md-12">
          <button type="submit" name="button" class="btn btn-primary">
            Guardar
          </button>
        </div>
      </div>
      </form>

        <div class="">
          {{$translations['en']}}{{-- al usar un custom paginator los links se muestran asi,,,estamos pagineando un json  --}}
        </div>
    @endisset




  </div>
@endsection
