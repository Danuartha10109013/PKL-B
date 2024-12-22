<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index(){
        $data = User::all();
        $lastUser = User::orderBy('no_pegawai', 'desc')->first();

        if ($lastUser) {
            $lastNoPegawai = intval(substr($lastUser->no_pegawai, 3));
            
            $newNoPegawai = 'EMP' . str_pad($lastNoPegawai + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNoPegawai = 'EMP001';
        }

        $nopegawai = $newNoPegawai;
        return view('pages.admin.pegawai.index',compact('data','nopegawai'));
    }

    public function add(Request $request)
    {
        // dd($request->all());
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'birthday' => 'required|date',
            'jabatan' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // optional avatar
            'no_pegawai' => 'required|string|unique:users,no_pegawai',
            'email' => 'nullable|email|unique:users,email',
            'gender' => 'nullable',
            'no_wa' => 'nullable',
            'tempat_lahir' => 'nullable',
        ]);

        // Insert new employee into the database
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->birthday = $request->birthday;
        $user->jabatan = $request->jabatan;
        $user->no_pegawai = $request->no_pegawai;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->no_wa = $request->no_wa;
        $user->alamat = $request->alamat;
        $user->role = 1;
        $user->alamat = null;
        $user->active = 1;
        $user->password = Hash::make('ShabatMakmur');
        if($request->gender == 'Laki-Laki'){
            $user->profile = 'avatars/man.jpg';
        }else{
            $user->profile = 'avatars/woman.jpg';
        }
        if ($request->hasFile('avatar')) {
            // Delete the old profile picture if it exists
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }
    
            // Store the new profile picture
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->profile = $avatarPath;
        }

        $user->save();

        // Redirect to the list of employees with success message
        return redirect()->route('admin.kelolapegawai')->with('success', 'Employee added successfully.');
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6', // Password validation
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Limit file size to 2MB
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user data
        $user->name = $request->name;
        $user->username = $request->username;
        $user->jabatan = $request->jabatan;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->birthday = $request->birthday;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->no_wa = $request->no_wa;

        // Handle the password update
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); // Hash the new password
        }

        // Handle the avatar upload
        if ($request->hasFile('avatar')) {
            // Delete the old avatar if it exists
            if ($user->profile) {
                Storage::delete($user->profile);
            }

            // Store the new avatar and update the profile path
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->profile = $path;
        }

        // Save the updated user data
        $user->save();

        // Redirect with success message
        return redirect()->route('admin.kelolapegawai')->with('success', 'Employee updated successfully.');
    }


    public function active($id){
        $data = User::find($id);
        $data->active = 1;
        $data->save();
        return redirect()->route('admin.kelolapegawai')->with('success', 'Akun '.$data->name . ' telah active');
    }
    public function nonactive($id){
        $data = User::find($id);
        $data->active = 0;
        $data->save();
        return redirect()->route('admin.kelolapegawai')->with('success', 'Akun '.$data->name . ' telah nonactive');
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Akun '. $user->name . ' telah dihapus');
    }
}
