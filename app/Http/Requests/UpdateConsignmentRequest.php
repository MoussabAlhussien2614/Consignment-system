<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateConsignmentRequest extends FormRequest
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
            'reference_no' => ['required', 'string', 'max:255', Rule::unique('consignments', 'reference_no')->ignore($this->route('consignment'))],
            'delivered_at' => ['nullable', 'date', 'before_or_equal:now'],
            'status' => ['required', 'in:pending,in_progress,closed'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.sku' => ['nullable', 'string', 'max:255'],
            'items.*.category_id' => ['required', 'exists:categories,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.extra_expences' => ['nullable', 'numeric', 'min:0'],
            'items.*.commission_rate' => ['required', 'integer', 'min:0', 'max:100'],
            'items.*.notes' => ['nullable', 'string'],
        ];
    }
}
