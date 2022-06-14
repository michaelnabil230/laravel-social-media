<?php

namespace App\Http\Requests;

use App\Rules\HttpImageRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:255', new HttpImageRule()],
            'community_id' => ['required', 'integer', 'exists:communities,id'],
        ];
    }
}
