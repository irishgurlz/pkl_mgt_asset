<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Actor;
use App\Models\Employee;
use App\Models\Karyawan;
use App\Models\Admin;
use App\Models\SuperAdmin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        session()->forget('selected_role');
        return view('auth.login');
    }
    public function showLoginForm()
    {
        session()->forget('selected_role');
        return view('auth.login');
    }

    public function showLoginFormSuper()
    {
        session()->forget('selected_role');
        return view('auth.login-super');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'nik' => 'exists:actor,nik',
            'password' => 'required',
        ]);

        $actor = Actor::where('nik', $request->nik)->first();

        if (!$actor) {
            return back()->withErrors(['login_error' => 'NIK tidak tersedia']);
        }

        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt(['nik' => $request->nik, 'password' => $request->password, 'role' => 'admin'], $remember)) {
            $roles = Actor::where('nik', $request->nik)->pluck('role'); 
            if ($roles->count() > 1) {
                session(['user_id' => Auth::guard('admin')->user()->id]);
                session(['selected_roles' => $roles]); 
                return redirect()->route('choose-role');
            }
            return redirect()->intended('/admin/dashboard');
        }

        if (Auth::guard('karyawan')->attempt(['nik' => $request->nik, 'password' => $request->password, 'role' => 'karyawan'], $remember)) {
            $roles = Actor::where('nik', $request->nik)->pluck('role'); 
            if ($roles->count() > 1) {
                session(['user_id' => Auth::guard('karyawan')->user()->id]);
                session(['selected_roles' => $roles]); 
                return redirect()->route('choose-role');
            }
            return redirect()->intended('/karyawan/dashboard');
        }

        return back()->withErrors(['login_error' => 'Password is invalid'])->withInput();
    }

    public function register(){
        return view('auth.register');
    }

    
    public function verifyRegister(Request $request){
        $request->validate([
            'nik' => 'required|string|max:255|exists:employee,nik|unique:actor,nik',
            'password' => 'required|min:3',
        ]);

        $employee = Employee::where('nik', $request->nik)->first();

        $karyawan = Karyawan::create([
            'nama' => $employee->nama,
        ]);
        $karyawan->actors()->create([
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
        ]);

        return redirect('/')->with('success', 'Akun berhasil ditambahkan.');
    }


    public function registerSuper(){
        return view('auth.register-super');
    }

    
    
    public function selectRole(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,karyawan',
        ]);
    
        $role = $request->input('role');
        session(['selected_role' => $role]);
    
        $userId = session('user_id');
        if ($role == 'karyawan' && $userId) {
            Auth::guard('karyawan')->loginUsingId($userId);
            return redirect('/karyawan/dashboard');
        } elseif ($role == 'admin' && $userId) {
            Auth::guard('admin')->loginUsingId($userId);
            return redirect('/admin/dashboard');
        }
    
        return redirect()->back()->withErrors(['Invalid role selection or authentication failed.']);
    }
    
    
    
    public function chooseRole()
    {
        $selectedRoles = session('selected_roles', []);
    
        return view('choose_role', compact('selectedRoles'));
    }
    
    public function logout()
    {
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        }
        else if(Auth::guard('karyawan')->check()){
            Auth::guard('karyawan')->logout();
        }
        session()->flush();
        return redirect(route('auth.index'));
    }

    public function showResetForm()
    {
        return view('auth.passwords.reset');
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|exists:employee,nik',
            'password' => 'required|min:3|confirmed',
        ]);
    
        $users = Actor::where('nik', $request->nik)->get(); 
    
        if ($users->isEmpty()) {
            return back()->withErrors(['nik' => 'No account found with this nik.']);
        }
    
        foreach ($users as $user) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
    
        return redirect()->route('auth.index')->with('success', 'Password has been reset. You can now log in with your new password.');
    }
    



    
    public function showResetFormSuper()
    {
        return view('auth.passwords.reset-super');
    }


    public function updateRole(Request $request, $id)
    {

        $actor = Actor::where('nik', $id)->first();
        
        if ($actor) {
            $admin = Admin::create([
                'nama' => $actor->employee->nama,
            ]);
            

            if (!$admin) {
                return redirect('/employee')->with('error', 'Failed to create Admin.');
            }

            $actorCreate = Actor::create([
                'nik' => $actor->nik,
                'password' => Hash::make($actor->password), 
                'role' => 'admin', 
                'user_id' => $admin->id, 
                'user_type' => 'Admin', 
            ]);
    
            return redirect('/employee')->with('success', 'Role updated to admin successfully.');
        }
    
        return redirect('/employee')->with('error', 'Actor not found.');
    }

    public function deleteRole(Request $request, $id)
    {
        $employee = Employee::where('nik', $id)->first();
    
        if (!$employee) {
            return redirect('/employee')->with('error', 'Employee not found.');
        }
    
        $admin = Admin::where('nama', $employee->nama)->first();
        if ($admin) {
            $admin->delete();
        }
    
        $actor = Actor::where('nik', $id)
                      ->where('role', 'admin')
                      ->first();
        if ($actor) {
            $actor->delete();
        }
    
        if (Auth::check() && Auth::user()->nik === $id) {
            $stillAdmin = Actor::where('nik', $id)
                               ->where('role', 'admin')
                               ->exists();
    
            if (!$stillAdmin) {
                Auth::logout();
                session()->flush();
                return redirect('/login')->with('success', 'Anda otomatis logout karena sudah bukan admin');
            }
        }
    
        return redirect('/employee')->with('success', 'Role deleted successfully.');
    }
    
    



}
