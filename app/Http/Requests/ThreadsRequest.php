<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadsRequest extends FormRequest
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
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ];
    }

     public function messages()
    {
        return [
            'title.required'            => 'The title is required',
            'body.required'             => 'The Body is required',
            'channel_id.required'       => 'The channel is required'
        ];
    }
}
