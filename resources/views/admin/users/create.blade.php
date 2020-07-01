@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Create Users</div>

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


            <form method="POST" action="{{route('admin.users.store')}}">
              @csrf

              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="role" class="col-md-4 col-form-label text-md-right"> <strong>{{ __('Role') }}</strong> </label>

                    <div class="col-md-6 ">

                        @foreach ($data['roles'] as $role)
                          <input  type="checkbox" class="m-2 form-control @error('role') is-invalid @enderror" name="role[]" value="{{$role->name}}" >{{$role->name}}<br>
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
                                  <td><input  type="checkbox" class="m-2 form-control @error('job_title') is-invalid @enderror" name="job_title[]" value='{{$country->id.','.$title->id}}' ></td>
                                @endforeach
                              </tr>
                              @endforeach
                        </table>
                        </div>
                      </div>



                      <br>


                    <div class="form-group row">
                      <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                      <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                          @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                      </div>

                      <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                          <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                          </button>
                        </div>
                      </div>
                    </form>




                  </div>
                </div>
              </div>
            </div>
          </div>
        @endsection
