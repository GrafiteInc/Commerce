<?php

namespace Mlantz\Hadron\Requests;

use App\Http\Requests\Request;
use Mlantz\Hadron\Models\SubscriptionPlans;

class CreateSubscriptionsRequest extends Request
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
        return SubscriptionPlans::$rules;
    }

}
