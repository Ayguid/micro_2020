@extends('layouts.app')

@php
$product = $data['product'];
$category = $data['category'];
$categories = $data['categories'];
$hash3d=0;

$files = $product->files;
// $files ='';


$lang=App::getLocale();
if ($lang == 'Pt-BR') {
  $lang='pt';
}
@endphp

@section('content')
  <div class="container">


    @isset($data['categories'])
      <div class="d-flex flex-wrap justify-content-start">
        @include('components.category-menu')
      </div>
    @endisset

    @isset($data['category'])
      <div class="row">
        <div class="col-6">

          <h4 class="m-2">{{$category->father-> {'title_' . $lang} ?? $category->father->title_es}}->
            <a href="{{route('getCategoryData', $category->id)}}">
              {{$category-> {'title_' . $lang} ?? $category->title_es}}</a>
            </h4>

          </div>

        </div>
      @endisset





      @isset($product)
        <product-view
        :can_edit='{!! json_encode((Auth::user())? Auth::user()->hasRole(['superadmin', 'admin']):null) !!}'
        :can_edit_route='{!! json_encode(route('admin.prods.edit', $product->id)) !!}'
        :product='{!! json_encode($product) !!}'
        ></product-view>
      @endisset


    </div>

  @endsection
