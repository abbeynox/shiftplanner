<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
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
            'description' => 'required|max:500',
            'contact' => 'max:500',
            'owner_email' => 'required|email',
            'allow_unsubscribe' => 'boolean',
        ];
    }

    /**
     * Messages for validation errors
     * @return string[]
     */
    public function messages()
    {
        return [
            'title.required' => __("plan.titleRequired"),
            'description.required'  => __('plan.descriptionRequired'),
            'contact.max'  => __('plan.contactMax'),
            'owner_email.required'  => __('plan.emailRequired'),
        ];
    }
}
