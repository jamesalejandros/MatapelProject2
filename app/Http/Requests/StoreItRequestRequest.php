<?php

namespace App\Http\Requests;

use App\Models\ItRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreItRequestRequest extends FormRequest
{
    /**
     * ==========================================================
     * AUTHORIZE
     * ==========================================================
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', ItRequest::class) ?? false;
    }

    /**
     * ==========================================================
     * RULES
     * ==========================================================
     */
    public function rules(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | JENIS PERMINTAAN
            |--------------------------------------------------------------------------
            */

            'jenis_permintaan' => [
                'required',
                'array',
                'min:1',
            ],

            'jenis_permintaan.*' => [
                'integer',
                'distinct',
                Rule::exists('mstjenispermintaan', 'id')
                    ->where(function ($query) {
                        $query->where('is_active', true);
                    }),
            ],

            /*
            |--------------------------------------------------------------------------
            | ISI REQUEST
            |--------------------------------------------------------------------------
            */

            'Permintaan' => [
                'required',
                'string',
                'max:65535',
            ],

            /*
            |--------------------------------------------------------------------------
            | KETERANGAN
            |--------------------------------------------------------------------------
            */

            'Keterangan' => [
                'nullable',
                'string',
                'max:65535',
            ],

            /*
            |--------------------------------------------------------------------------
            | ASSET
            |--------------------------------------------------------------------------
            */

            'assets' => [
                'nullable',
                'array',
            ],

            'assets.*' => [
                'string',
                'distinct',
                Rule::exists('mstasset', 'NoAssetIT'),
            ],

            /*
            |--------------------------------------------------------------------------
            | RELATED USERS
            |--------------------------------------------------------------------------
            */

            'related_users' => [
                'nullable',
                'array',
            ],

            'related_users.*' => [
                'integer',
                'distinct',
                Rule::exists('users', 'id')
                    ->whereNotNull('NIK'),
            ],
        ];
    }

    /**
     * ==========================================================
     * MESSAGES
     * ==========================================================
     */
    public function messages(): array
    {
        return [
            'jenis_permintaan.required'
                => 'Jenis permintaan wajib dipilih.',

            'jenis_permintaan.array'
                => 'Format jenis permintaan tidak valid.',

            'jenis_permintaan.min'
                => 'Minimal satu jenis permintaan harus dipilih.',

            'jenis_permintaan.*.exists'
                => 'Jenis permintaan yang dipilih tidak valid atau sudah tidak aktif.',

            'Permintaan.required'
                => 'Permintaan wajib diisi.',

            'Keterangan.string'
                => 'Keterangan harus berupa teks.',

            'assets.array'
                => 'Format asset tidak valid.',

            'assets.*.exists'
                => 'Asset IT yang dipilih tidak ditemukan.',

            'related_users.array'
                => 'Format user terkait tidak valid.',

            'related_users.*.exists'
                => 'User terkait tidak valid.',
        ];
    }
}
