<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPhone implements ValidationRule
{

    /*
     *  this rule checks whether phone IDs are valid for the same user
     */

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $currentPhones = collect($this->user->phones)->pluck('id')->all();

        if(! collect($value)->every(function ($phone) use ($currentPhones) {

            return in_array($phone['id'] , $currentPhones);

        })) {

            $fail('One or more of the provided phone IDs are invalid');
        }
    }
}
