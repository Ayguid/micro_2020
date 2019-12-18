@extends('layouts.app')
@section('content')
  <div class="container">

    {{-- <h3>{{session('country.country_desc')}}</h3> --}}
    @if (!isset($data['category']))
          {{-- <h6 class="p-2">{{Lang::get('messages.welcome')}}</h6> --}}
    @endif

    @php
    $lang=App::getLocale();
    // if ($lang== 'pt-BR') {
    //   $lang='pt';
    // }
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
      @php
      $admin=Auth::guard('admin')->check();
      @endphp
      <div class="row">
        @foreach ($data['products'] as $product)
          @include('components.product-preview')
        @endforeach
      </div>
      <div class="d-flex justify-content-around">
        {{ $data['products']->appends(request()->except('page'))->links() }}
      </div>

      @if ($data['products']->count()==0)
        <p>No se encontraron productos</p>
        <a class="btn btn-primary" href="{{url()->previous()}}">Back</a>
      @endif
    @endisset


    </div>
  @endsection
