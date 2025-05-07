@extends('layouts.auth')

@section('title', 'Esqueci a senha')

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
            <div class="card-body login-card-body">
                <p class="login-box-msg text-rosa"><b>Digite seu email para recuperar a senha</b></p>

                @session('status')
                    <div class="alert alert-success" role="alert">
                        {{ $value }}

                      </div>
                @endsession
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" />

                        <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        @error('email')
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
                    <a href="{{route('register')}}" class="text-center text-rosa"> Cadastre-se aqui </a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

@endsection
