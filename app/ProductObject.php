<?php
    /**
     * Created by PhpStorm.
     * User: Perry
     * Date: 26-Jul-19
     * Time: 4:20 PM
     */

    namespace App;


    class ProductObject
    {
        private $ProductCode;
        private $ProductName;
        private $Price;
        private $UnitOfMeasurement;
        private $Measurement;

        /**
         * ProductObject constructor.
         * @param $ProductCode
         * @param $ProductName
         * @param $Price
         * @param $UnitOfMeasurement
         * @param $Measurement
         */
        public function __construct($Products)
        {
            $this->ProductCode = $Products->get('ProductCode');
            $this->ProductName = $Products->get('ProductName');
            $this->Price = $Products->get('Price');
            $this->UnitOfMeasurement = $Products->get('UnitOfMeasurement');
            $this->Measurement = $Products->get('Measurement');
        }


    }