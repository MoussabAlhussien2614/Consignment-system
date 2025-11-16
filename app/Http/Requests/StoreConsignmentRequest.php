<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsignmentRequest extends FormRequest
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
        return [
            'vendor_id' => ['required', 'exists:vendors,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'reference_no' => ['required', 'string', 'max:255', 'unique:consignments,reference_no'],
            'delivered_at' => ['nullable', 'date', 'before_or_equal:now'],
            'status' => ['required', 'in:pending,in_progress,closed'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
