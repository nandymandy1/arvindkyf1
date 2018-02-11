@extends('layouts.auth')


@section('content')
<div class="card col-lg-4 mx-auto">
  <div class="card-body px-5 py-5">
    <h3 class="card-title text-left mb-3">Login</h3>
    <form method="POST" action="{{ route('login') }}">
        @csrf
      <div class="form-group">
        <label for="email">E-Mail Address</label>
          <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
      </div>
      <div class="form-group">
        <label for="password">Password</label>
          <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
      </div>
      <div class="form-group d-flex align-items-center justify-content-between">
        <div class="form-check">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>
        </div>
        <a class="forgot-pass" href="{{ route('password.request') }}">
            Forgot Your Password?
        </a>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary btn-block enter-btn">LOG IN</button>
      </div>
    </form>
  </div>
</div>



@endsection
