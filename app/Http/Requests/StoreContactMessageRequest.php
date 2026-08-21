<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['prohibited'], // honeypot field, must stay empty
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('contact.validation_name_required'),
            'email.required' => __('contact.validation_email_required'),
            'email.email' => __('contact.validation_email_invalid'),
            'message.required' => __('contact.validation_message_required'),
        ];
    }
}
