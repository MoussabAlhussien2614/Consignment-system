<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\ConsignmentItem;

class StoreSaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'item_id' => ['required', 'integer', Rule::exists('consignment_items', 'id')],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'extra_expenses' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            if (!$this->has('item_id')) return;

            $item = ConsignmentItem::find($this->input('item_id'));
            if (!$item) {
                $v->errors()->add('item_id', 'Selected item not found.');
                return;
            }

            $available = $item->quantity_available ?? 0;
            if ($this->input('quantity') > $available) {
                $v->errors()->add('quantity', 'Requested quantity exceeds available stock.');
            }

            $unit = $item->unit_price ?? 0;
            if ($this->input('price') < $unit) {
                $v->errors()->add('price', 'Sale price cannot be less than unit price ('.$unit.').');
            }
        });
    }
}
