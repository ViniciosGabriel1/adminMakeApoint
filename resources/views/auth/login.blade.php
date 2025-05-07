@extends('layouts.auth')

@section('title', 'Faça seu Login!')

@section('body-class', 'login-page bg-rosa')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a class="text-white" style="display: flex; flex-direction: column; align-items: center;">
                <img 
                    src="{{ Vite::asset('resources/images/Gleyce.png') }}" 
                    alt="Logo da Gleyce MakeUp" 
                    class="brand-image rounded-3"
                    style="width: 200px; height: 160px; margin-bottom: 10px;"
                >
                {{-- <span><b>Gleyce</b>MakeUp</span> --}}
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body rounded-5">
                <p class="login-box-msg text-rosa"><b>Faça login para acessar o sistema aqui!</b></p>
                @session('status')
                    <div class="alert alert-success" role="alert">
                        {{ $value }}
                      </div>
                @endsession
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" />


                        <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" value="{{ old('password') }}" />
                        <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        @error('password')
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
                <p class="m-1"><a class="text-rosa" href="{{route('password.request')}}">Esqueci minha senha.</a></p>
                <p class="mt-2">
                    <a href="{{route('register')}}" class="text-center text-rosa"> Cadastra-se </a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

@endsection
