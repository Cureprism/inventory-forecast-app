<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeParam = $this->route('product'); // Product または ID
        $productId  = $routeParam instanceof \App\Models\Product ? $routeParam->id : $routeParam;

        return [
        'name'           => ['required','string','max:100'],
        'product_code'   => ['required','string','max:50', Rule::unique('products','product_code')->ignore($productId)],
        'price'          => ['required','integer','min:1'],
        'safety_stock'   => ['required','integer','min:0'],
        'lead_time_days' => ['required','integer','min:0','max:365'],
        ];
    }
}
