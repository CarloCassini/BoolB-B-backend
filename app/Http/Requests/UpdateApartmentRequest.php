<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'title' => ['required', 'string', 'unique:apartments,title', 'max:50'],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'rooms' => ['required', 'integer', 'min:1', 'max:255'],
            'beds' => ['required', 'integer', 'min:0', 'max:255'],
            'bathrooms' => ['required', 'integer', 'min:0', 'max:255'],
            'm2' => ['required', 'integer', 'min:1'],
            'address' => ['required', 'string'],
            'services' => ['required', 'exists:services,id'],
            'is_hidden' => ['boolean'],
            'cover_image_path' => ['nullable', 'image'],
            // 'latitude_int',
            // 'longitude_int',
            // 'user_id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'title è obbligatiorio',
            'title.string' => 'title deve essere un testo',
            // 'title.unique' => 'title esiste già nel nostro Database',
            'title.max' => 'title deve essere max di 50 caratteri',

            'description.string' => 'description deve essere un campo testuale',

            'rooms.required' => 'rooms è obbligatorio',
            'rooms.between' => 'rooms deve essere minimo = 1 e massimo = 255',
            // 'rooms.max' => 'rooms deve essere al massimo = 255', 

            'beds.required' => 'beds è obbligatorio',
            'beds.min' => 'beds deve essere minimo = 0',
            'beds.max' => 'beds deve essere al massimo = 255',

            'bathrooms.required' => 'bathrooms è obbligatorio',
            'bathrooms.min' => 'bathrooms deve essere minimo = 0',
            'bathrooms.max' => 'bathrooms deve essere al massimo = 255',

            'm2.required' => 'bathrooms è obbligatorio',
            'm2.min' => 'bathrooms deve essere minimo = 1',

            'address.required' => 'address is required, select one suggestion',
            'address.string' => 'address must be selected from suggestions',

            'services.exists' => 'service unavable',
            'services.required' => 'choose at least one service',

            'is_hidden' => 'non può essere diverso da visibile o nascosto',

            'cover_image_path.image' => 'La cover image deve essere un\'immagine'
        ];
    }
}