<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[\d\s\+\-\(\)]+$/'],
            'email' => ['nullable', 'email', 'max:100'],
            'package_id' => ['required', 'integer', 'exists:packages,id'],
            'billing_cycle_date' => ['required', 'integer', 'min:1', 'max:28'],
            'first_billing_date' => ['required', 'date'],
            'initial_payment_status' => ['required', 'in:PAID,UNPAID'],
        ];
    }
}
