<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_title' => ['required', 'string', 'between:2,100'],
            'course_link' => ['required', 'string', 'min:7'],
            'tags' => ['required', 'string'],
            'lesson_title.*' => ['required', 'string', 'between:2,100'],
            'lesson_link.*' => ['required', 'string', 'min:7'],
        ];
    }
}
