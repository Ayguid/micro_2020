@component('mail::message')

<img src="http://plankwebdev.com/micro/images/logos/logo%20micro%20sin%20placa.jpg" alt="" width="200px">

{{ __('messages.greeting') }} ** Micro **.


{{ __('messages.will_reply') }} .
 {{-- use double space for line break --}}
{{ __('messages.from') }} : **{{$toMail}}**

{{-- **{{$product}}** --}}
@isset($product)
@php
  $prod = json_decode($product);
@endphp

**{{ __('messages.title') }} : {{$prod->title_es}}**

**{{ __('messages.description') }} :{{$prod->desc_es}}**

**{{ __('messages.code') }}o : {{$prod->product_code}}**
@endisset



**<p>
  {{ __('messages.comments') }}:
  {{$textArea}}
</p>**




{{-- @component('mail::button', ['url' => $link])
@endcomponent --}}



@endcomponent
