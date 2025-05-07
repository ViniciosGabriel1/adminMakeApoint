@extends('layouts.auth')
@section('title', 'Faça seu Cadastro!')

@section('body-class', 'register-page bg-rosa')

@section('content')

    <div class="register-box">
  
        <div class="register-logo">
            <x-logo/>

        </div>
        <!-- /.register-logo -->
        <div class="card">
            <div class="card-body register-card-body">
                <p class="register-box-msg text-rosa"><b>Cadastre-se aqui.</b></p>
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Full Name" value="{{old('name')}}"  />

                        <div class="input-group-text"><span class="bi bi-person"></span></div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{old('email')}}" />
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
                    <!--begin::Row-->
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
                <p class="mt-3">
                    <a href="{{route('login')}}" class=" text-center text-rosa"> Já tenho uma conta. </a>
                </p>
            </div>
        </div>
    </div>
@endsection
