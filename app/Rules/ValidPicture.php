<?php

    namespace App\Rules;

    use Illuminate\Contracts\Validation\Rule;

    class ValidPicture implements Rule
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
            $file_extension = $value->getClientOriginalExtension();
            //This switch is to check if the file is really a photo.
            //If not, we will not save the file.
            $hasValidExtension = false;
            switch ($file_extension) {
                case 'jpg':
                    $hasValidExtension = true;
                case 'png':
                    $hasValidExtension = true;
                case 'gif':
                    $hasValidExtension = true;
                case 'JPG':
                    $hasValidExtension = true;
                case 'PNG':
                    $hasValidExtension = true;
                case 'GIF':
                    $hasValidExtension = true;
            }
            return $hasValidExtension;
        }

        /**
         * Get the validation error message.
         *
         * @return string
         */
        public function message()
        {
            return 'אנא העלה קובץ תמונה תקין בפורמט JPH,PNG,GIF בלבד';
        }
    }
