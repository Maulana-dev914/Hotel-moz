<?php

namespace App\Http\Requests;

use App\Rules\MozambiquePhone;
use App\Rules\MozambiqueDocument;
use Illuminate\Foundation\Http\FormRequest;

class StorePublicReservationRequest extends FormRequest
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
        $rules = [
            'reservation_type' => 'required|in:person,company',
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'notes' => 'nullable|string',
        ];

        if ($this->reservation_type === 'person') {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email';
            $rules['phone'] = ['required', new MozambiquePhone()];
            $rules['document_type'] = 'required|in:bi,passport,driving_license';
            $rules['document'] = ['required', new MozambiqueDocument($this->document_type ?? 'bi')];
        } else {
            $rules['company_name'] = 'required|string|max:255';
            $rules['company_email'] = 'required|email';
            $rules['company_phone'] = ['required', new MozambiquePhone()];
            $rules['company_document_type'] = 'nullable|in:nuit,company_registration';
            if ($this->company_document_type) {
                $rules['company_document'] = ['required', new MozambiqueDocument($this->company_document_type)];
            }
            $rules['contact_person'] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
