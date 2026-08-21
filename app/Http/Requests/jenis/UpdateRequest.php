<?php

namespace App\Http\Requests\Jenis;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID dari route parameter (misal: /jenis/{jeni})
        $jenisId = $this->route('jeni') ? $this->route('jeni')->id : $this->route('jenis');

        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jenis', 'nama')->ignore($jenisId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama jenis makanan wajib diisi.',
            'nama.unique' => 'Nama jenis makanan ini sudah digunakan.',
            'nama.max' => 'Nama jenis makanan maksimal 255 karakter.',
        ];
    }
}