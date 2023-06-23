<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartSimulationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'humanNumber' => 'required|min:1|max:500',
            'zombieNumber' => 'required|min:1|max:500',
            'encounterChance' => 'min:1|max:100|integer',
            'chanceForBite' => 'min:40|max:100|integer',
            'injuryChance' => 'min:1|max:50|integer',
            'immuneChance' => 'min:1|max:50|integer',
        ];
    }
}
