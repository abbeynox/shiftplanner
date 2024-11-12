<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportPlanRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // [
        return [
            "import" => "file|required|mimetypes:text/csv,text/plain|max:1024"
        ];
    }

    /**
     * Messages for validation errors
     * @return string[]
     */
    public function messages()
    {
        return [
            'import.required'  => __('plan.importRequired'),
            'import.file'  => __('plan.importFile'),
            'import.mimetype'  => __('plan.importMimetype'),
            'import.max'  => __('plan.importMax'),
        ];
    }

}
