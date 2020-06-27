<?php
use Illuminate\Support\Facades\DB;
if (isset($ref)){
    $v = DB::select("select 1 from users where email = ?",[$ref]);
    if(!$v) echo "<script>alert('Referral Code Does not exist!!' )</script>";
}

?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
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
                            <label for="teamName" class="col-md-4 col-form-label text-md-right">{{ __('FPL Team Name') }}</label>

                            <div class="col-md-6">
                                <input id="teamName" type="text" class="form-control @error('team_name') is-invalid @enderror" name="team_name" value="{{ old('teamName') }}" required autocomplete="name" autofocus>

                                @error('team_name')
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


                        <div class="form-group row">
                            <label for="bank" class="col-md-4 col-form-label text-md-right">{{ __('Bank') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" id="bank" name="bank">

                                    <option value="">Select Bank..</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="acct" class="col-md-4 col-form-label text-md-right">{{ __('Account No') }}</label>

                            <div class="col-md-6">
                                <input id="acct" type="text" class="form-control @error('acct') is-invalid @enderror" name="acct" >
                                <small id="info"></small>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ref_code" class="col-md-4 col-form-label text-md-right">{{ __('Referral Code') }}</label>

                            <div class="col-md-6">
                                <input id="ref_code" type="text" class="form-control @error('ref_code') is-invalid @enderror" name="ref_code" value="{{ isset($ref) ? $ref: '' }}">

                                @error('ref_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" onclick="" class="btn btn-primary">
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
                        $('#bank').html(data);

                    })
            }
        });

        $("#acct").blur(function(){

            if ($(this).val().length === 10 && $("#code").val() != "" ) {
                let code = $("#bank").children("option:selected"). val()
                let acct = $(this).val()
                $('#info').text('validating account...');
                $.post("{{ route('ajax-helper') }}",
                    {req: 'fetch_acct', code: code, acct:acct, '_token': "{{ csrf_token() }}" }, function (data, status) {
                        // console.log(status);
                        $('#info').text(data);

                    })
            }
        });



    });
</script>
@endsection
