@extends('layouts.auth')

@section('body-class', 'login-page')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../index2.html"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

              
                <form action="{{ route('password.update') }}" method="post">

                    @csrf
                    
                    {{-- {{dd(request()->token)}} --}}

                    <input type="hidden" name="token" value="{{request()->token}}">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ request()->email }}" />

                        <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>  
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" value="{{old('password')}}"/>
                        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="Password-confirmation" value="{{old('password_confirmation')}}" />
                        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="row">

                        <!-- /.col -->
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </form>

                <!-- /.social-auth-links -->
                <p class="mb-1"><a href="forgot-password.html">I forgot my password</a></p>
                <p class="mb-0">
                    <a href="register.html" class="text-center"> Register a new membership </a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

@endsection
