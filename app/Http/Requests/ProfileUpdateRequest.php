<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('product');
        return [
            'name'            => ['required','string','max:100'],
            'sku'             => ['required','string','max:50',"unique:products,sku,{$id}"],
            'safety_stock'    => ['required','integer','min:0'],
            'lead_time_days'  => ['required','integer','min:0','max:365'],
        ];
    }
}
