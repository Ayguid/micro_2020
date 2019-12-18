<div class="bg-dark col-3 border mt-2 pt-2">
  <a href="{{route('showProduct', $product)}}">
    <h5>Titulo : {{$product-> {'title_' . $lang} ?? $product->title_es}}  </h5>
    <h6>Codigo : {{$product->product_code}}</h6>
    @if ($images = $product->getFiles()['images'])
      @foreach ($images as $image)
        <img class="productPic" width="100%" src="{{asset('storage/product_images/'.$image->file_path)}}" alt="">
      @endforeach
    @else
      <img class="productPic" width="100%" src="{{asset('images/'.'default.jpeg')}}" alt="">
    @endif
  </a>

  <div class="p-3 mb-2 bg-secondary text-dark">
    <div class="row ">

      <div class="col-2">
        @if ($product->has_pdf)
          <img class="logo" src="{{asset('icons/pdf_logo.svg')}}" alt="">
        @endif
      </div>

      <div class="col-2">
        @if ($product->has_cad_3d)
          <img class="logo" src="{{asset('icons/cad_logo.svg')}}" alt="">
        @endif
      </div>

      <div class="col-2">
        @if ($product->has_zip)
          <img class="logo" src="{{asset('icons/zip_logo.svg')}}" alt="">
        @endif
      </div>

    </div>
  </div>

  <h6>{{$product-> {'desc_' . $lang} ?? $product->desc_es}}</h6>
  @foreach ($product->attributes as $att)
    @if ($att->attribute->filterable)
      <strong>{{$att->attribute-> {'name_' . $lang} ?? $att->attribute->name_es}}</strong><br>
      {{$att->value}} <br>
    @endif
  @endforeach
  {{-- <div class="row">
    @include('components.product-attributes')
  </div> --}}
  @if ($admin)
    <a href="{{route('editProduct', $product->id)}}">edit</a>
  @endif
</div>
