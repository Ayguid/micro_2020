@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">

          <div class="card-header">Cat</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif


            @php
            $category = $data['category'];
            @endphp

            @isset($category)
              @if ($category->parent_id)
                <a class="" href="{{route('admin.cats.show', $category->parent_id)}}">{{$category->father()->first()->title_es}}</a>
              @endif



              <div class="row">
                <div class="col-4 mt-2">
                  <div class="d-flex justify-content-start">

                    <h3 >{{$category->title_es}}</h3>
                    @role('superadmin')
                    <a href="{{route('admin.cats.edit', $category->id)}}" class=""><img src="{{asset('/icons/edit_icon.svg')}}" alt="" width="30px"></a>
                    {{-- <a href="#" class=""><img src="{{asset('/icons/edit_icon.svg')}}" alt="" width="30px"></a> --}}
                    @endrole
                  </div>
                </div>

              </div>



              @if (!$category->parent_id)
                <h4 class="mt-2 text-center">Atributos</h4>
                <div class="p-3 mb-2 bg-secondary rounded">
                  <div class="row">
                    @foreach ($category->attributes as $attr)
                      <div class="col-6 col-md-4 col-lg-3 p-2">
                        {{-- <a class="text-white" href="#">{{$attr->name_es}}</a> --}}
                        @if (auth()->user()->hasRole('superadmin'))
                          <a class="text-white" href="{{route('admin.atts.edit',$attr->id)}}">{{$attr->name_es}}</a>
                        @else
                          <span class="text-white">{{$attr->name_es}}</span>

                        @endif
                        @if ($attr->filterable)
                          <img src="{{asset('icons/lens_icon.svg')}}" alt="">
                        @endif
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif




              @if ($category->children->count()>0)
                <h4 class="mt-2">Sub Categorias</h4>
                <div class="sub-cats">
                  <div class="row">
                    @foreach ($category->children as $child)
                      <div class="col-12 col-md-6 col-lg-4 col-xl-3 m-0 p-2">
                        <a href="{{route('admin.cats.show', $child->id)}}" class="btn btn-primary btn-lg btn-block">{{$child->title_es}}</a>
                        {{-- <a href="#" class="btn btn-primary btn-lg btn-block">{{$child->title_es}}</a> --}}
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif



              @role('superadmin')
              @if (!$category->parent_id)
                <div id="accordion">
                  <div class="card">
                    <div class="card-header" id="headingOne">
                      <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Agregar Sub Categoria
                        </button>
                      </h5>
                    </div>
                    <div id="collapseOne" class="collapse "aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="card-body">


                        <form method="POST" action="{{route('admin.cats.store')}}">
                          @csrf
                          <input type="text" name="parent_id" value="{{$category->id}}" hidden>

                          <div class="row">
                            @foreach ($category->getFillable() as $fValue)

                              @if ($fValue !=='parent_id')
                                <div class="form-group col-md-4">
                                  <label for="">{{$fValue}}</label>
                                  <input class="form-control{{ $errors->has($fValue) ? ' is-invalid' : '' }}" type="text" name="{{$fValue}}" value="">
                                  @if ($errors->has($fValue))
                                    <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first($fValue) }}</strong>
                                    </span>
                                  @endif
                                </div>
                              @endif

                            @endforeach
                          </div>


                          <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                Agregar sub categoria
                              </button>
                            </div>
                          </div>
                        </form>

                      </div>
                    </div>
                  </div>
                </div>


                <div id="accordion2">
                  <div class="card">
                    <div class="card-header" id="headingTwo">
                      <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                          Agregar Atributos
                        </button>
                      </h5>
                    </div>
                    <div id="collapseTwo" class="collapse "aria-labelledby="headingTwo" data-parent="#accordion2">
                      <div class="card-body">
                        {{-- @include('admin.forms.add-attribute-form') --}}
                      </div>
                    </div>
                  </div>
                </div>
              @endif

              {{-- @if ($category->father()->count()>0) --}}
              @if ($category->parent_id)
                <div class="">
                  <div id="accordionProduct">
                    <div class="card">
                      <div class="card-header" id="headingProduct">
                        <h5 class="mb-0">
                          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProduct">
                            Agregar Producto
                          </button>
                        </h5>
                      </div>
                      <div id="collapseProduct" class="collapse "aria-labelledby="headingProduct" data-parent="#accordionProduct">
                        <div class="card-body">
                          @include('admin.forms.add-product-form')
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @endrole

              <div class="">

                @foreach ($data['products'] as $prod)
                  <div class="row">

                    <div class="col-3">

                      @role('superadmin')
                      <a href="{{route('admin.prods.edit', $prod->id)}}">Edit</a>
                      @endrole

                      @if ($prod->has_image)
                        {{-- {{dd($prod->orderedFiles('img'))}} --}}
                        @foreach ($prod->orderedFiles('img') as $img)
                          <img class="productPic" width="100%" src="{{asset('storage/product_images/'.$img->file_path)}}" alt="">
                        @endforeach

                      @else
                        <img class="productPic" width="100%" src="{{asset('images/default.jpeg')}}" alt="">
                      @endif
                    </div>

                    <div class="col-9">
                      <h3>{{$prod->product_code}}</h3>
                      <h4>{{$prod->title_es}}</h4>
                    </div>

                  </div>



                @endforeach

                {{$data['products']->links() }}

              </div>










            @endisset




          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
