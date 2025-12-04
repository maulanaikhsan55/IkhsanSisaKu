<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KarangTarunaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $karangTarunaId = $this->route('karang_taruna');

        $rules = [
            'nama_karang_taruna' => 'required|string|max:150',
            'nama_lengkap' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:30',
            'rw' => [
                'required',
                'string',
                'max:10',
                Rule::unique('karang_taruna', 'rw')->ignore($karangTarunaId)
            ],
            'status' => 'required|in:aktif,nonaktif',
        ];

        // Validation for user (only on create)
        if ($this->isMethod('post')) {
            $rules['username'] = 'required|string|max:50|unique:users,username';
            $rules['email'] = 'required|email|max:150|unique:users,email|regex:/@gmail\.com$/i';
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama_karang_taruna.required' => 'Nama Karang Taruna wajib diisi',
            'rw.required' => 'RW wajib diisi',
            'rw.unique' => 'RW sudah terdaftar',
            'status.required' => 'Status wajib dipilih',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'email.regex' => 'Email harus menggunakan domain @gmail.com',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ];
    }
}