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

    public function divideTagToArray()
    {
        return explode(',', $this->tags);   
    }

    public function getLessonsArray()
    {
        $lessons_count = count($this->lesson_title);

        $lessons_array = [];

        for ($i=0; $i < $lessons_count ; $i++) { 
            $lesson_array = [
                'title' => $this->lesson_title[$i],
                'link' => $this->lesson_link[$i]
            ];

            array_push($lessons_array, $lesson_array);
        }

        return $lessons_array;

        


    }
}
