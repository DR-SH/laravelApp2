<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title'=>'required| regex:/^[a-zа-я\s]+$/iu|min:3',
            'about'=>'required|min:3',
            'authors'=>['required'],
        ];
    }
    
    /**
     * Custom error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Название должно быть заполнено',
            'title.min' => 'Название должно содержать не менее 3х символов',
            'title.regex' => 'Название не может содержать символы',
            'about.required'  => 'Описание должно быть заполнено',
            'about.min'  => 'Описание должно содержать не менее 3х символов',
            'authors.required'  => 'Книга должна содержать хотя бы одного автора',
        ];
    }
}
