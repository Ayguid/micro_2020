<div class="col-12 d-md-none mt-2 mb-2">
  <button class="btn btn-outline-primary btn-block" type="button" data-toggle="collapse" data-target="#catMenu" aria-controls="catMenu" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
    <span class="">Categorias</span>
  </button>
</div>

<div class="navbar navbar-expand-md navbar-light p-0">
  <div class="collapse navbar-collapse" id="catMenu">
    <div class="row">
      @foreach ($data['categories'] as $cat)
        <div class="col-12 col-md-4 col-lg-3">
          <div class="btn-group col-12 mb-1 p-0">
            <button type="button" class="btn btn-primary dropdown-toggle  w-100" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{$cat-> {'title_' . $lang} ?? $cat->title_es}}</button>
              <div class="dropdown-menu">
                @foreach ($cat->getSubCategories as $sub)

                  <a class="dropdown-item bg-light" href="{{route('getCategoryData', $sub->id)}}">{{$sub-> {'title_' . $lang} ?? $sub->title_es}}</a>
                  {{-- <a class="dropdown-item bg-light" href="#">{{$sub-> {'title_' . $lang} ?? $sub->title_es}}</a> --}}
                @endforeach
              </div>
            </div>
            @if (!isset($data['category']) && !isset($data['products']))
              <div class="col-12">
                <img src="{{asset('storage/categories/'.$cat->image_path)}}" alt="" width="100%">
              </div>
            @endif
          </div>
        @endforeach

        @if (session('country')->id==2 || session('country')->country_desc == "Brasil")
          <div class="col-12 col-md-4 col-lg-3">
            <a target="_blank" href="https://www.schmalz.com/en/" class="w-100 btn btn-primary"> <img width="22%" src="https://www.schmalz.com/skin/frontend/schmalz/default/images/logo.svg" alt=""> </a>
          </div>
        @endif

      </div>
    </div>
  </div>
