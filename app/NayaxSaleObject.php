<?php
    /**
     * Created by PhpStorm.
     * User: Perry
     * Date: 26-Jul-19
     * Time: 4:20 PM
     */

    namespace App;


    class NayaxSaleObject
    {
        private $Amount;
        private $TransactionId;
        private $Products;
        private $Descriptor;
        private $CurrencyCode;
        private $CountryCode;

        /**
         * NayaxSaleObject constructor.
         * @param $Amount
         * @param $TransactionId
         * @param $Products
         * @param $Descriptor
         * @param $CurrencyCode
         * @param $CountryCode
         */
/*        public function __construct($request)
        {
            //dd($newserials);
            $area = json_decode($request, true);
            dd($area);
            $this->Amount = $request->get('Amount');
            $this->TransactionId = $request->get('TransactionId');
            //$this->Products = $Products;
            //$this->Descriptor = $Descriptor;
            $this->CurrencyCode = $request->get('CurrencyCode');
            $this->CountryCode = $request->get('CountryCode');
            this.$Products = new ProductObject($request->get('Products'));
            this.$Descriptor = new DescriptorObject( $request->get('Descriptor'));
        }*/

    }