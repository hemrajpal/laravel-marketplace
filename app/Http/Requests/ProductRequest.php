<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'type' => [
                'required',
                'in:product,service',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'detail' => [
                'required',
                'string',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'country' => [
                'required',
                'string',
                'max:100',
            ],

            'state_id' => [
                'required',
                'exists:states,id',
            ],

            'city_id' => [
                'required',
                'exists:cities,id',
            ],

            'area' => [
                'required',
                'string',
                'max:150',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'images' => $isUpdate
                ? [
                    'nullable',
                    'array',
                    'max:10',
                ]
                : [
                    'required',
                    'array',
                    'min:1',
                    'max:10',
                ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Please select a type.',
            'type.in' => 'The selected type is invalid.',

            'name.required' => 'Please enter a product name.',
            'name.max' => 'The product name may not exceed 255 characters.',

            'detail.required' => 'Please enter product details.',

            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',

            'country.required' => 'Please select a country.',

            'state_id.required' => 'Please select a state.',
            'state_id.exists' => 'The selected state is invalid.',

            'city_id.required' => 'Please select a city.',
            'city_id.exists' => 'The selected city is invalid.',

            'area.required' => 'Please enter an area.',

            'price.required' => 'Please enter a price.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price cannot be negative.',

            'images.required' => 'Please upload at least one image.',
            'images.array' => 'Images must be uploaded as an array.',
            'images.min' => 'Please upload at least one image.',
            'images.max' => 'You can upload a maximum of 10 images.',

            'images.*.image' => 'Each uploaded file must be an image.',
            'images.*.mimes' => 'Images must be JPG, JPEG, PNG, or WEBP.',
            'images.*.max' => 'Each image must not exceed 5 MB.',
        ];
    }
}