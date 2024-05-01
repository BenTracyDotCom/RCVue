<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UrlBlob implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
      $urlOrBlob = '/^((http|https):\/\/\S+)|(blob:\S+)/i';
      return preg_match($urlOrBlob, $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid URL or Blob.';
    }
}