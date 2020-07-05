@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">User: </div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif
            @if(session('alert-success'))
              <div class="alert alert-success"><i class="fa fa-check" aria-hidden="true"></i> <strong>{!! session('alert-success') !!}</strong></div>
            @endif
            @if(session('alert-danger'))
              <div class="alert alert-danger"><i class="fa fa-times" aria-hidden="true"></i> <strong>{!! session('alert-danger') !!}</strong></div>
            @endif


            <form  method="POST" action="{{route('admin.users.update', $data['user']->id)}}">
              @csrf

              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                  <input {{!$data['edit']?'disabled':''}} id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$data['user']->name}}" required autocomplete="name" autofocus>

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                  <div class="col-md-6">
                    <input {{!$data['edit']?'disabled':''}} id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$data['user']->email}}" required autocomplete="email">

                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                    <div class="col-md-6 ">

                      @foreach ($data['roles'] as $role)
                        <input {{!$data['edit']?'disabled':''}}  type="checkbox" {{$data['user']->hasRole($role->name)?'checked':''}} class="m-2 form-control @error('role') is-invalid @enderror" name="role[]" value="{{$role->name}}" >{{$role->name}}<br>
                        @endforeach


                        @error('role')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>


                    <br>

                    <div class="form-group row">
                      <label for="role" class="col-md-4 col-form-label text-md-right"></label>

                      <div class="col-md-6 ">
                        <table class="table">
                          <tr>
                            <th scope="col">Country</th>
                            @foreach ($data['job_titles'] as $title)
                              <th scope="col">{{$title->name}}</th>
                            @endforeach
                          </tr>

                          @foreach ($data['countries'] as $country)
                            <tr>
                              {{-- <input  type="checkbox" class="m-2 form-control @error('country') is-invalid @enderror" name="country[]" value="{{$country->id}}" >{{$country->country_desc}}<br> --}}
                              <th scope="row">{{$country->country_desc}}</th>
                              @foreach ($data['job_titles'] as $title)
                                {{-- {{$data['user']->hasTitle($country->id, $title->id)}} --}}
                                <td><input {{!$data['edit']?'disabled':''}} {{$data['user']->hasTitle($country->id, $title->id)?'checked':''}}  type="checkbox" class="m-2 form-control @error('job_title') is-invalid @enderror" name="job_title[]" value='{{$country->id.','.$title->id}}' ></td>
                                @endforeach
                              </tr>
                            @endforeach
                          </table>
                        </div>

                      </div>



                      <br>


                      @can('edit users')
                        @if (!$data['edit'])
                          <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                              <a class="btn btn-primary" href="{{route('admin.users.edit', $data['user']->id)}}">
                                {{ __('Edit') }}
                              </a>
                            </div>
                          </div>
                        @else
                          <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                              </button>
                            </div>
                          </div>
                        @endif
                      @endcan

                    </form>


                    @if ($data['edit'])
                    <div class="">
                      <form id="deleteForm" class="" action="{{route('admin.users.destroy', $data['user']->id)}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                          {{ __('Delete') }}
                        </button>
                      </form>
                    </div>
                  @endif


                  </div>
                </div>
              </div>
            </div>
          </div>
        @endsection
        <script type="text/javascript">

        window.addEventListener('load', (event) => {

          var deleteForm = document.getElementById('deleteForm');
          deleteForm.onsubmit = function(event){
            console.log(event);
            event.preventDefault();
            if (confirm('Estas Seguro? Esto no puede deshacerse')) {
              deleteForm.submit();
            }
          }

        });
        </script>
