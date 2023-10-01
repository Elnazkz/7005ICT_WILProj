<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinWordsCount implements ValidationRule
{
    public int $parameter;

    public function __construct($param)
    {
        $this->parameter = $param;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $res = str_word_count($value, 0);
        if ($res < $this->parameter) {
            $fail('At least must contains ' . $this->parameter . ' words');
        }
    }
}
