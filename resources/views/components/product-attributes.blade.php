


<div class="col-12 col-md-6 col-lg-6">
  @foreach ($product->attributes as $att)
    @if ($att->attribute->filterable)
      <strong>{{$att->attribute-> {'name_' . $lang} ?? $att->attribute->name_es}}</strong><br>
      {{$att->value}} <br>
    @endif
  @endforeach
</div>



<div class="col-12 col-md-6 col-lg-6">
  @foreach ($product->attributes as $att)
    @if (!$att->attribute->filterable)
      <strong>{{$att->attribute-> {'name_' . $lang} ?? $att->attribute->name_es}}</strong><br>
      {{$att->value}} <br>
    @endif
  @endforeach
</div>
