<?php

namespace Modules\Category\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray(Request $request)
    {
        return [
            'Category id'=>$this->id,
            'Category Name '=>$this->name,
            'Category Description '=>$this->description,
        ];
    }
}
