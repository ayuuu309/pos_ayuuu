<?php

namespace App\Http\Requests\Jenis;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255|unique:jenis,nama',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama jenis makanan wajib diisi.',
            'nama.unique' => 'Nama jenis makanan ini sudah ada.',
            'nama.max' => 'Nama jenis makanan maksimal 255 karakter.',
        ];
    }
}