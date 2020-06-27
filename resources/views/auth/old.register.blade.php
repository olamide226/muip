

@extends('layouts.app')
@section('title', 'Register Page')

 @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">

             <form class="text-center border border-light p-5 form-group" id="main" action="{{ route('register') }}" >
              @method('POST')
              @csrf
                  <p class="h4 mb-4">Sign up </p>


                  <div class="form-row mb-4">
                      <div class="col">
                          <!-- First name -->
                          <input type="text" id="firstName" required name="firstName"  class="form-control" autofocus placeholder="First name">
                           @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                      </div>
                      <div class="col">
                          <!-- Last name -->
                          <input type="text" id="lastName" required name="lastName"  class="form-control" placeholder="Last name">
                          @error('lastName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                      </div>
                  </div>

                  <!-- E-mail -->
                  <input type="email" id="user_email" required name="email" class="form-control mb-4"  placeholder="E-mail">
                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                  <!-- Password -->
                  <input type="password" id="user_password" name="password" required class="form-control" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock">
                  <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                      At least 6 characters
                  </small>
                  @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                  <!-- Confirm Password -->
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                      Must be the same with password above
                  </small>
                  <div class="row">
                      <div class="col-md-6">
                        <!-- Phone number -->
                        <input type="text" id="teamName" name="teamName" required class="form-control" placeholder="FPL Team Name"  aria-describedby="defaultRegisterFormPhoneHelpBlock">
                        @error('teamName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror

                      </div>
                      <div class="col-md-6">
                        <input type="text" id="code" name="code" class="form-control" placeholder="Referral Code" value="{{ isset($ref) ? $ref: '' }}">
                      </div>
                  </div><br>
                  <div class="form-group" id='details' >
                    <!-- <label for="sel1">Select Bank</label> -->
                    <select class="form-control" id="sel1" name="bank">

                      <option value="">Select Bank..</option>
                    </select>
                    <hr/>

                  <input type="text" name="acct" id="acct" value="" class="form-control" placeholder='Account No' maxlength=11>
                  <small id="act"></small>

                  </div>

                  <!-- <div class="ajax-loader" id="loading-image">
                    <img src="public/ajax-loader.gif" class="img-responsive" />
                  </div> -->


                  <!-- Newsletter -->
                  <!-- <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="defaultRegisterFormNewsletter">
                      <label class="custom-control-label" for="defaultRegisterFormNewsletter">Subscribe to our newsletter</label>
                  </div> -->
                  <!-- <script src="https://js.paystack.co/v1/inline.js"></script> -->
              <!-- <button type="button" onclick="payWithPaystack()"> Pay </button> -->
                  <!-- Sign up button -->
                  <button class="btn btn-info my-4 btn-block" onclick="" type="submit">Sign up</button>

                  <hr>
                    <a href="{{ route('login') }}">Already registered? Login here </a>
                  <!-- <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="http://localhost/fpl/register/payment.php" allowfullscreen></iframe>
            </div> -->

              </form>
  <!-- Default form register -->
              </div>
            </div>
        </div>
    </div>
</div>
  <script>
      $(function () {
//         $('#loading-image').bind('ajaxStart', function(){
//     $(this).show();
// }).bind('ajaxStop', function(){
//     $(this).hide();
// });

        $("#teamName").blur(function(){

          if ($(this).val() != "" ) {

            $.post("{{ route('ajax-helper') }}",
              {req: 'fetch_banks', '_token': "{{ csrf_token() }}" }, function (data, status) {
              console.log(status);
              $('#sel1').html(data);
              $('#details').slideDown();

            })
          }
        });

        $("#acct").blur(function(){

          if ($(this).val().length == 10 && $("#code").val() != "" ) {
            let code = $("#sel1").children("option:selected"). val()
            let acct = $(this).val()
            $('#act').text('loading...');
            $.post("{{ route('ajax-helper') }}",
              {req: 'fetch_acct', code: code, acct:acct, '_token': "{{ csrf_token() }}" }, function (data, status) {
              console.log(status);
              $('#act').text(data);

            })
          }
        });


        $('for').on('submit', function (e) {

          e.preventDefault();

          // if ($('#user_password').val() == $('#user_cpassword').val()) {
          //   payWithPaystack();
          // }else {
          //   alert("Passwords must match");
          // }
          submit();


        });

      });
    </script>
    @endsection
