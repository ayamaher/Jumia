<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PhonesRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'country_id' => ['nullable', 'integer'],
            'state' => ['required', Rule::in(['ALL', 'OK', 'NOK'])]
        ];
    }
}
