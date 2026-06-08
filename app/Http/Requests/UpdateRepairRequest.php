<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepairRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'model'          => ['required', 'string', 'max:255'],
            'category'       => ['required', 'string', 'max:255'],
            'estimated_cost' => ['required', 'numeric', 'min:0'],
            'downpayment' => ['required', 'numeric', 'min:0'],
            'status'         => ['required', 'string', 'in:pending,ongoing,completed'],
        ];
    }
}
