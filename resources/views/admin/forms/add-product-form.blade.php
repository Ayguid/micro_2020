
<form id="" class="addProductForm" action="{{route('admin.prods.store')}}" method="post">
  {{ csrf_field() }}

  @php
  $prod=new App\Models440\Product();
  @endphp


  <div class="row">
    <div class="col-12 m-0 p-0">
    <div class="bg-info text-white p-2">
  <h4>El producto se encuentra en</h4>
  <div class="row">

  @foreach ($prod->possibleCountries() as $country)
    <div class="col-2">
      <input checked type="checkbox" name="country_id[]" value="{{$country->id}}">
      <label for="{{$country->country_desc}}">{{$country->country_desc}}</label>
    </div>
  @endforeach
</div>
</div>
</div>
</div>


<hr>

  <div class="row bg-primary text-white">
    <div class="col-12">
        <h5>Informacion principal del producto</h5>
<div class="row">

    @foreach ($prod->getFillable() as $fValue)
      @if ($fValue =='category_id')
        <input type="text" name="category_id" value="{{$category->id}}" hidden>
      @endif
      @if ($fValue !=='category_id' && $fValue !=='has_image'&& $fValue !=='has_pdf'&& $fValue !=='has_cad_2d'&& $fValue !=='has_cad_3d' && $fValue !=='has_zip')
        <div class="form-group col-md-4">
          @if ($fValue =='desc_es'|| $fValue =='desc_en' || $fValue =='desc_pt')
            <label for="{{$fValue}}">{{$fValue}}</label>
            <textarea class="form-control{{ $errors->has($fValue) ? ' is-invalid' : '' }}" name="{{$fValue}}">{{ old($fValue) }}</textarea>
          @else
          <label for="{{$fValue}}">{{$fValue}}</label>
          <input class="form-control{{ $errors->has($fValue) ? ' is-invalid' : '' }}" type="text" name="{{$fValue}}" value="{{ old($fValue) }}">
        @endif
          @if ($errors->has($fValue))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first($fValue) }}</strong>
            </span>
          @endif
        </div>
      @endif
    @endforeach
  </div>
  </div>
  </div>

<hr>

  <div class="row">
    <div class="bg-info text-white col-12">

    <h5>Attributos del producto</h5>

    <div class="col-10 offset-1">
      <div class="row">
        @foreach ($category->grandParent()->attributes()->get() as $val)
          <div class="form-group col-6">
            @if ($val->type=="textarea")
              <label for="">{{$val->name_es}}</label>
              <textarea rows="8" cols="80" name="attributes[{{$val->id}}]" value=""></textarea>
            @endif
            @if ($val->type=="float")
              <label for="">{{$val->name_es}}</label>
              <input class="form-control{{ $errors->has($val->name_es) ? ' is-invalid' : '' }}" type="number" step="0.1" name="attributes[{{$val->id}}]" value="">
            @endif
            @if ($val->type=="string")
              <label for="">{{$val->name_es}}</label>
              <input class="form-control{{ $errors->has($val->name_es) ? ' is-invalid' : '' }}" type="text" name="attributes[{{$val->id}}]" value="">
            @endif
          </div>
        @endforeach
      </div>
      </div>
    </div>
  </div>
<hr>
  <button type="submit" name="button" class="btn btn-primary">Guardar nuevo producto</button>
</form>
