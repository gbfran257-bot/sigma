<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CfdiValidationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'Fecha' => 'required',
            'Folio' => 'required',
            'FormaPago' => 'required',
            'LugarExpedicion' => 'required',
            'MetodoPago' => 'required',
            'Moneda' => 'required',
            'Serie' => 'required',
            'SubTotal' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'TipoDeComprobante' => 'required',
            'Emisor.RegimenFiscal' => 'required',
            'Receptor.Nombre' => 'required',
            'Receptor.Rfc' => 'required',
            'Receptor.UsoCFDI' => 'required',
            'Receptor.DomicilioFiscalReceptor' => 'required',
            'Receptor.RegimenFiscalReceptor' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido.',
            'regex' => 'El formato del campo :attribute no es válido.',
        ];
    }
}
