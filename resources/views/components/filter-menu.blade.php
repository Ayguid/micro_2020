
@if ($data['products']->count()>0)
  @php
  $prodAtts=$data['products_attributes']
  @endphp
  <span class="p-2">Cantidad de productos correspondientes a los filtros</span> <span id="productCount" class="p-2"></span>
  <form  id="filterForm" class="" action="{{route('productsCat', $category->id)}}" method="get">
    <div class="row">
      <input type="number" name="country_id" value="{{session('country')->id}}" hidden>
      <input type="number" name="category_id" value="{{$category->id}}" hidden>
      @foreach ($prodAtts as $key => $prodAtt)
        <div class="input-group mb-3 col-3">
          <div class="input-group-prepend">
            <label class="input-group-text " for="">
              {{$prodAtt->attribute-> {'name_' . $lang} ?? $prodAtt->attribute->name_es}}
            </label>
          </div>

          <select  class="custom-select " name="attribute_ids[{{$prodAtt['attribute']['id']}}]">
            <option value="null" class="">--</option>
            @foreach ($prodAtt->uniquePossibleValues($category->id) as $value)
              <option class="" {{($data['attribute_ids'][$prodAtt->attribute_id]==$value->value)?'selected':null}} value="{{$value->value}}">{{$value->value}}</option>
            @endforeach
          </select>

        </div>
        <br>
      @endforeach
    </div>
      <div class="row">

      <div class="input-group mb-3 col-3">
        <input id="submitSearch" class="form-control" type="submit"  value="{{Lang::get('messages.search')}}">
      </div>
      <div class="input-group mb-3 col-3">
        <input class="form-control" id="restartFilter" type="button" value="{{Lang::get('messages.reset_filters')}}">
      </div>
    </div>
  </form>
@endif
<filter-helper :who="'filterForm'" :display="'productCount'">
</filter-helper>
