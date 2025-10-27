<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'     => ['required', 'string', 'max:50'],
            'postal_code'   => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address'       => ['required', 'string', 'max:255'],
            'building'      => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required'   => 'ユーザー名は必須です。',
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.regex'    => '郵便番号は「123-4567」の形式で入力してください。',
            'address.required'     => '住所は必須です。',
            'profile_image.image'  => 'プロフィール画像は画像ファイルを選択してください。',
            'profile_image.mimes'  => '画像は jpeg, png, jpg, gif 形式でアップロードしてください。',
            'profile_image.max'    => '画像サイズは2MB以内にしてください。',
        ];
    }
}