<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
        $maxFileUrlSize = env('FILE_URL_SIZE') * 1024;
        $maxPrintFileUrlSize = env('PRINT_FILE_URL_SIZE') * 1024;

        return [
            'sku' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'edition' => 'nullable|string|max:50',
            'isbn' => 'nullable|string|max:20',
            'publication_date' => 'required|date',
            'copyright' => 'nullable|string|max:255',
            'paper_height' => 'nullable|string|max:10',
            'paper_width' => 'nullable|string|max:10',
            'cover_height' => 'nullable|string|max:10',
            'cover_width' => 'nullable|string|max:10',
            'pages' => 'nullable|integer|min:1',
            'color' => 'nullable|string|max:50',
            'category_id' => 'required|integer|exists:book_categories,id',
            'file_url' => 'nullable|file|mimes:pdf|max:'. $maxFileUrlSize,
            'print_file_url' => 'nullable|file|mimes:pdf,docx|max:'. $maxPrintFileUrlSize,
            'total_cost' => 'nullable|numeric|min:0',
            'editor' => 'nullable|numeric|min:0',
            'researcher' => 'nullable|numeric|min:0',
            'writer' => 'nullable|numeric|min:0',
            'graphic_designer' => 'nullable|numeric|min:0',
            'layout_designer' => 'nullable|numeric|min:0',
            'photographer' => 'nullable|numeric|min:0',
            'markup_fee' => 'nullable|numeric|min:0',
        ];
    }
}
