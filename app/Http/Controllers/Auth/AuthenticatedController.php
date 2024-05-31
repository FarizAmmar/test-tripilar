<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{

    public $user_model;
    public $company_model;

    public function __construct(Company $company, User $user)
    {
        $this->user_model = $user;
        $this->company_model = $company;
    }

    // Halaman Index untuk login page
    public function login_view()
    {
        return view('pages.authenticated.login');
    }

    // Halaman Index untuk Register page
    public function register_view()
    {
        return view('pages.authenticated.register');
    }

    // Menyimpan user baru
    public function register_store(Request $request)
    {
        // Validation
        $request->validate([
            'company_name' => 'required|string|unique:companies,company_name|max:30',
            'name' => 'required|string|unique:users,name|max:30',
            'email' => 'required|email|unique:users,email|max:30',
            'password' => 'required',
        ], [
            'company_name.required' => 'Company name is required.',
            'company_name.unique' => 'Company name has already been taken.',
            'company_name.max' => 'Company name must not be more than :max characters.',
            'name.required' => 'Username is required.',
            'name.unique' => 'Username has already been taken.',
            'name.max' => 'Username must not be more than :max characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Email address must be a valid email format.',
            'email.unique' => 'Email address has already been taken.',
            'email.max' => 'Email address must not be more than :max characters.',
            'password.required' => 'Password is required.',
        ]);

        try {
            // Save the company record
            $this->company_model->SaveRecord($request->input('company_name'));

            // To get id
            $company = $this->company_model->FetchRecordByName($request->input('company_name'));

            // Save the user record with company_id
            $userData = new User([
                'company_id' => $company->id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role_id' => 1,
                'password' => bcrypt($request->input('password')),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->user_model->SaveRecord($userData);

            // Redirect to login page upon successful registration
            return redirect(route('auth.login'))->with('success', 'Registration successful. Please log in.');
        } catch (\Throwable $th) {
            // Redirect back with an error message
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    // Login authentication
    public function login_store(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Email address must be a valid email format.',
            'password.required' => 'Password is required.',
        ]);

        // Authenticate the user
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember-me');

        if (Auth::attempt($credentials, $remember)) {
            // Authentication successful, redirect to the intended page or dashboard
            return redirect()->intended(route('user.list'));
        } else {
            // Authentication failed, redirect back with error message
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('auth.login'));
    }
}
