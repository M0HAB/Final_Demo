<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class submitQuizAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ['user_id' => 'required'];

        //validating array of radio buttons --> does not return with data
        foreach($this->request->get('choices.*') as $b => $y)
        {
            $rules['choices.'.$b] = 'required';
        }


        return $rules;
    }
}
