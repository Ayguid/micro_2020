@extends('layouts.app')
@section('content')
  <div class="container">

    {{-- <h3>{{session('country.country_desc')}}</h3> --}}
    {{-- @if (!isset($data['category']))
          <h6 class="p-2">{{Lang::get('messages.welcome')}}</h6>
    @endif --}}

    @php
    $lang=App::getLocale();
    if ($lang == 'Pt-BR') {
      $lang='pt';
    }
    @endphp

    @isset($data['categories'])
      <div class="">
        @include('components.category-menu')
      </div>
    @endisset


    @isset($data['category'])
      {{-- <h3>{{$data['category']->father-> {'title_' . $lang} ?? $data['category']->father->title_es}}->{{$data['category']-> {'title_' . $lang} ?? $data['category']->title_es}}</h3> --}}
      <products-portfolio
        :country='{!! json_encode(session('country')) !!}'
        :category='{!! json_encode($data['category']) !!}'
      ></products-portfolio>
    @endisset


    @isset($data['products'])
      @if ($data['products']->count() == 0)
        <div class="mt-4">
          <h4>{{__('messages.No se encontraron productos.')}}</h4>
        </div>
      @endif
      <div class="row">
        @foreach ($data['products'] as $prod)
          <product-component class="col-12 col-md-4 col-lg-3"
          :product='{!! json_encode($prod) !!}'
          :product_route_view='{!! json_encode(route('showProduct', $prod->id)) !!}'
          :cat_route='{!! json_encode(route('getCategoryData', $prod->category)) !!}'>
        </product-component>
        @endforeach
      </div>
      <div class="d-flex justify-content-around">
        {{ $data['products']->appends(request()->except('page'))->links() }}
      </div>
    @endisset


    </div>
  @endsection
