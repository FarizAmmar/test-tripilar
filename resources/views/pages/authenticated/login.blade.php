@extends('layouts.app')

@section('main-content')
    <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 d-table h-100 mx-auto">
            <div class="d-table-cell align-middle">

                <div class="mt-4 text-center">
                    <h1 class="h2">Welcome back!</h1>
                    <p class="lead">
                        Sign in to your account to continue
                    </p>
                </div>

                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="m-sm-3">
                            <form action="{{ route('auth.login.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        type="email" name="email" placeholder="Enter your email"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        type="password" name="password" placeholder="Enter your password" />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="form-check align-items-center">
                                        <input id="customControlInline" type="checkbox" class="form-check-input"
                                            value="remember-me" name="remember-me">
                                        <label class="form-check-label text-small" for="customControlInline">Remember
                                            me</label>
                                    </div>
                                </div>
                                <div class="d-grid mt-3 gap-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mb-3 text-center">
                    Don't have an account? <a href="{{ route('auth.register') }}">Sign up</a>
                </div>
            </div>
        </div>
    </div>
@endsection
