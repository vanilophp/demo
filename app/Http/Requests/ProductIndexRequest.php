<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class ProductIndexRequest extends FormRequest
{
    public function filters(Collection $properties)
    {
        $filters = [];

        foreach ($this->query() as $propertySlug => $values) {
            if ($properties->contains(function ($property) use ($propertySlug) {
                return $property->slug == $propertySlug;
            })) {
                $filters[$propertySlug] = is_array($values) ? $values : [$values];
            }
        }

        return $filters;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
