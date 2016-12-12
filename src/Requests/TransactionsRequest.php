<?php

namespace Quarx\Modules\Hadron\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Quarx\Modules\Hadron\Models\Transactions;

class TransactionsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return Transactions::$rules;
    }
}
