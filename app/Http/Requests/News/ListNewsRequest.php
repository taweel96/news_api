<?php

namespace App\Http\Requests\News;

use App\Enums\NewsSources;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListNewsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sources' => 'nullable|array',
            'sources.*' => ['string', Rule::enum(NewsSources::class)],
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
        ];
    }
}
