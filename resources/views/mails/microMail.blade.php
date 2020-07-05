@component('mail::message')
Te esta contactando **{{$fromMail}}**,
 {{-- use double space for line break --}}
Para : @foreach ($toMail as $key => $eachToMail)
  @if ($key==0)
    **{{$eachToMail->email}}**
    @else
      **, {{$eachToMail->email}}**
  @endif
@endforeach

{{-- **{{$product}}** --}}
@isset($product)
@php
  $prod = json_decode($product);
@endphp

**Titulo : {{$prod->title_es}}**

**Descripcion :{{$prod->desc_es}}**


**Codigo : {{$prod->product_code}}**
@endisset



**<p>
  Comentarios:
  {{$textArea}}
</p>**




{{-- @component('mail::button', ['url' => $link])
@endcomponent --}}



@endcomponent
