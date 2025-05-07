@extends('layouts.auth')

@section('title', 'Recupere sua senha')

@section('body-class', 'login-page bg-rosa')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <x-logo/>

        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg text-rosa"><b>Crie uma nova senha</b></p>

              
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
                                <button type="submit" class="btn btn-rosa">Sign In</button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </form>

                <!-- /.social-auth-links -->
                <p class="mb-1"><a class="text-rosa" href="{{route('login')}}">Já tenho uma conta</a></p>
                <p class="mb-0">
                    <a href="{{route('register')}}" class="text-center text-rosa"> Register a new membership </a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

@endsection
