<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuestRequest extends FormRequest
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
        $guest = $this->route('guest');
        $guestId = $guest ? $guest->id : null;
        return [
            'name' => 'required|string|max:255',
            'document' => 'required|string|unique:guests,document,' . $guestId,
            'phone' => 'required|string',
            'email' => 'required|email',
        ];
    }
}
