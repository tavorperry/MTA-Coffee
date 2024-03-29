<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Mailgun\Mailgun;

class ValidEmailMailgun implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
        # Instantiate the client.
        $mgClient = new Mailgun('pubkey-7250f008ac3e46a83d068f6f561b6143');
        $validateAddress = $value;
        # Issue the call to the client.
        //$result = $mgClient->get("address/validate", array('address' => $validateAddress));
        $result = $mgClient->get("address/validate", array('address' => $validateAddress));
        # is_valid is 0 or 1
        $isValid = $result->http_response_body->is_valid;
        } catch (\Exception $exception) {
            return compact('isValid','exception') ;
        }
      return $isValid;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'האימייל שהזנת אינו פעיל. אנא בדוק את הקלט והקלד אימייל פעיל';
    }
}
