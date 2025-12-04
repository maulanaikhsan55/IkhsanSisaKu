<?php

namespace App\Http\Controllers\KarangTaruna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('karang-taruna.pengaturan.index');
    }

    public function update(Request $request)
    {
        if ($request->has('change_password')) {
            return $this->updatePassword($request);
        }

        return $this->updateProfile($request);
    }

    private function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id() . '|regex:/@gmail\.com$/i',
            'no_telp' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        
        $user->update($request->only(['username', 'email']));
        
        if ($user->karangTaruna) {
            $user->karangTaruna->update($request->only(['nama_lengkap', 'no_telp']));
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    private function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
