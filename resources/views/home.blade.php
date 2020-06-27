@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body77">
                    @if (session('status') == 'success')
                        <div class="alert alert-success" role="alert">

                            <strong>Success!</strong> Check mail for more details.
                            <small>Check spam in case you didnt see email in inbox</small>
                        </div>
                    @endif
                    @if (session('sub_status') !== 'success')
                            <div class="alert alert-warning" role="alert">

                                <strong>Alert!</strong> Your referral account not setup properly due to invalid account details supplied
                                <small>Contact Admin to configure your referral link</small>
                            </div>
                     @endif


                            <table class="table table-striped table-responsive">
                    <thead class="thead-dark">
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>No of Referals</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td>5</td>
                      </tr>
                      <tr>
                        <td>Mary Moe</td>
                        <td>mary@example.com</td>
                        <td>3</td>
                      </tr>
                      <tr>
                        <td>July Dooley</td>
                        <td>july@example.com</td>
                        <td>1</td>
                      </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
