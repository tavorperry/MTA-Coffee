<?php
    /**
     * Created by PhpStorm.
     * User: Perry
     * Date: 26-Jul-19
     * Time: 6:10 PM
     */

    namespace App;


    class StatusObject
    {
        public $Verdict;
        public $ErrorCode;
        public $ErrorDescription;
        public $StatusMessage;

        /**
         * StatusObject constructor.
         * @param $Verdict
         * @param $ErrorCode
         * @param $ErrorDescription
         * @param $StatusMessage
         */
        public function __construct($Verdict, $ErrorCode, $ErrorDescription, $StatusMessage)
        {
            $this->Verdict = $Verdict;
            $this->ErrorCode = $ErrorCode;
            $this->ErrorDescription = $ErrorDescription;
            $this->StatusMessage = $StatusMessage;
        }


    }

