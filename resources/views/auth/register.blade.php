@extends('layouts.auth')

@section('content')
<div class="card col-lg-4 mx-auto">
  <div class="card-body px-5 py-5">
    <h3 class="card-title text-left mb-3">Register</h3>
    <form method="POST" action="{{ route('register') }}">
        @csrf
      <div class="form-group">
        <label for="name" class="col-form-label">Name</label>
        <input id="name" type="text" placeholder="Name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

        @if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group">
        <label for="username" class="col-form-label">Username</label>
        <input id="username" type="text" placeholder="Username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

        @if ($errors->has('username'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group">
        <label for="email" class="col-form-label">E-Mail Address</label>
        <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group">
        <label for="password" class="col-form-label">Password</label>
        <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group">
        <label for="password-confirm" class="col-form-label">Confirm Password</label>
        <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required>
      </div>

      <div class="form-group">
        <label for="factory" class="col-form-label">Factory</label><br>
        <!--<input id="factory" placeholder="Factory" type="text" class="form-control{{ $errors->has('factory') ? ' is-invalid' : '' }}" name="factory">-->

        <select class="custom-select form-control" name="factory" id="factory">

        </select>

        @if ($errors->has('factory'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('factory') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group">
        <label for="factory" class="col-form-label">Job</label><br>
        <!--<input id="factory" placeholder="Factory" type="text" class="form-control{{ $errors->has('factory') ? ' is-invalid' : '' }}" name="factory">-->
        <select class="custom-select form-control" name="job">
          <option selected>Choose Your Job</option>
          <option value="cutting">Cutting</option>
          <option value="sewing">Sewing</option>
          <option value="finishing">Finishing</option>
          <option value="strength">Qualit and Strength</option>
        </select>
        @if ($errors->has('job'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('job') }}</strong>
            </span>
        @endif
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary btn-block enter-btn">Register</button>
      </div>
    </form>
  </div>
</div>
@endsection


@section('scripts')

<script type="text/javascript">
$(document).ready(function(){
  factoryValue();
});

function factoryValue(){
  $("#factory").empty();
  $("#factory").append('<option name="none" value="">Loading...</option>');
  $.ajax({
    url: "/factorylist",
    type: "get",
    data:{
      factory: "factory",
    },
    contentType: "json",
    success: function (factoryV){
      $("#factory").empty();
      console.log(factoryV);
      $("#factory").append('<option name="none" value="">--Choose Factory--</option>');
      for(var i =0; i <factoryV.length ; i++){
        $("#factory").append('<option name="none" value="'+factoryV[i].name+'">'+factoryV[i].name+'</option>');
      }

    }
  });
}

</script>


@endsection
