@extends('layouts.app')

@section('main-content')
    <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 d-table h-100 mx-auto">
            <div class="d-table-cell align-middle">

                <div class="mt-4 text-center">
                    <h1 class="h2">Get started</h1>
                    <p class="lead">
                        Start creating the best possible user experience for you customers.
                    </p>
                </div>

                <div class="card">
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="m-sm-3">
                            <form action="{{ route('auth.register.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input
                                        class="form-control form-control-lg @error('company_name')
                                        is-invalid
                                    @enderror"
                                        type="text" name="company_name" placeholder="Enter your company name"
                                        value="{{ old('company_name') }}" />
                                    @error('company_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Full name</label>
                                    <input
                                        class="form-control form-control-lg @error('name')
                                    is-invalid
                                @enderror"
                                        type="text" name="name" placeholder="Enter your name"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input
                                        class="form-control form-control-lg @error('email')
                                    is-invalid
                                @enderror"
                                        type="email" name="email" placeholder="Enter your email"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input
                                        class="form-control form-control-lg @error('password')
                                    is-invalid
                                @enderror"
                                        type="password" name="password" placeholder="Enter password" />
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-grid mt-3 gap-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mb-3 text-center">
                    Already have account? <a href="{{ route('auth.login') }}">Log In</a>
                </div>
            </div>
        </div>
    </div>
@endsection
