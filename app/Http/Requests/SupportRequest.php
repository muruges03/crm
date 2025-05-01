<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Allow the request to be used
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


    public function rules()
    {
        return [
            'description' => 'nullable',
            'legal_name' => 'required|string',
            'status' => 'nullable',
            'prefix' => 'nullable',
            'entity_id' => 'nullable'
        ];
    }
    public function getEntityId(){
        return session('entity_id');
    }

}
