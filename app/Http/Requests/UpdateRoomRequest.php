<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
        $room = $this->route('room');
        $roomId = $room ? $room->id : null;
        return [
            'number' => 'required|string|unique:rooms,number,' . $roomId,
            'type' => 'required|in:single,double,matrimonial',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
        ];
    }
}
