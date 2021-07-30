<?php declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'dateStart' => 'required|string|date_format:"Y-m-d H:i:s"',
            'dateEnd' => 'required|string|gte:dateStart|date_format:"Y-m-d H:i:s"',
            'usdTotal' => 'required|string',
            'images' => 'array',
        ];
    }
}
