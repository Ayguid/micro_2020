@component('mail::message')
Gracias por comunicarte con **{{$fromMail}}**,
 {{-- use double space for line break --}}
Para : **{{$toMail}}**

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
