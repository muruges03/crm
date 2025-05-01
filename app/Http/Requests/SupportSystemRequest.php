<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportSystemRequest extends FormRequest
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
            'service_type' => 'required|integer|exists:om_service_type,id',
            'service_by'   => 'nullable|integer',
            'description'  => 'nullable',
            'date'         => 'required|date',
            'tat_date'     => 'required|date',
            'tat_level'    => 'nullable|string',
            'made_by'      => 'nullable|integer',
            'customer_id'  => 'required|integer|exists:patrons,id',
            'status' => 'nullable',
            'client_name' => 'nullable',
            'application_id'  => 'required|exists:om_applications,id',
        ];
    }
    public function entity_id(){

        return session('entity_id');
    }
}
