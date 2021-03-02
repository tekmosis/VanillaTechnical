<?php

namespace App\Http\Requests;

class WidgetPutRequest extends WidgetPostRequest
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
}
