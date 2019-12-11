@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">

          <div class="card-header">attribute</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            {{-- {{$data}} --}}






            <form class="" action="{{route('admin.atts.update')}}" method="post">
              {{ csrf_field() }}


              @if ($errors->count()>0)
                <div class="alert alert-danger" role="alert">
                  @foreach ($errors->all() as $err)
                    <strong>{{$err}}</strong>
                  @endforeach
                </div>
              @endif

              {{-- <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a> --}}


              <div class="form-group row">

                <div class="col-md-6">
                  <label for="Atributo">Atributo</label>
                  <input autofocus class="form-control" type="text" name="name_es" value="{{$data['attribute']->name_es}}" placeholder="name_es">
                  <input  class="form-control" type="text" name="name_en" value="{{$data['attribute']->name_en}}" placeholder="name_en">
                  <input  class="form-control" type="text" name="name_pt" value="{{$data['attribute']->name_pt}}" placeholder="name_pt">
                  <label for="">Filterable</label>
                  <input  hidden value="" name="filterable">
                  <input  class="form-control" type="checkbox" {{($data['attribute']->filterable)? 'checked':''}} value="1" name="filterable">

                  <input class="form-control" type="number" name="category_id" value="{{$data['attribute']->category_id}}" hidden>
                  <input class="form-control" type="number" name="attribute_id" value="{{$data['attribute']->id}}" hidden>

                  <label for="Atributo">Tipo</label><br>
                  @foreach ($data['attribute']->types() as $key => $value)
                    <input {{($value == $data['attribute']->type)?'checked':''}} type="radio" value="{{$value}}" name="type">{{$value}}<br>
                  @endforeach
                </div>
              </div>



              <button type="submit" name="button" class="btn btn-primary">Guardar</button>
            </form>



          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
