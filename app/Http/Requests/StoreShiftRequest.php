<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreShiftRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:200',
            'type' => 'max:200',
            'description' => 'max:500',
            'group' => 'int|numeric|max:100|min:0',
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start',
            'team_size' => 'required|int|max:100|min:0|numeric',
            'repetition' => 'int|min:1|max:50|min:0|numeric',
            'repetition_type' => Rule::in(RepetitionType::cases()),
        ];
    }

    /**
     * Messages for validation errors
     * @return string[]
     */
    public function messages()
    {
        return [
            'title.required' => __("shift.titleRequired"),
            'start.required'  => __('shift.startRequired'),
            'start.before'  => __('shift.startBefore'),
            'end.required'  => __('shift.endRequired'),
            'end.after'  => __('shift.endAfter'),
            'team_size.required'  => __('shift.team_sizeRequired'),
        ];
    }
}
