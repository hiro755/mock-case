<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'condition' => 'required|in:良好,目立った傷や汚れなし,やや傷や汚れあり,状態が悪い',
            'category' => 'required|string',
            'price' => 'required|integer|min:1',
            'image' => 'nullable|image',
    ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.mimes' => '画像形式はjpegまたはpngである必要があります。',
            'category.required' => 'カテゴリーを選択してください。',
            'condition.required' => '商品の状態を選択してください。',
            'condition.in' => '商品の状態は「目立った傷や汚れなし」「やや傷や汚れあり」「状態が悪い」から選択してください。',
            'name.required' => '商品名を入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'brand.max' => 'ブランド名は255文字以内で入力してください。',
            'description.required' => '商品の説明を入力してください。',
            'description.max' => '商品の説明は1000文字以内で入力してください。',
            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は数値で入力してください。',
            'price.min' => '販売価格は1円以上で入力してください。',
        ];
    }
}
