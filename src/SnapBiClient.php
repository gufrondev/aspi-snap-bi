<?php

namespace App\Libraries\AspiSnapBI;

use App\Libraries\AspiSnapBI\Services\Transfer;
use App\Libraries\AspiSnapBI\Services\AccountInquiry;

class SnapBiClient
{
    public function __construct(
        public $provider = null
    ) {
        $this->provider = $provider;
    }

    /**
     * External account inquiry
     *
     * @param Array $data
     */
    public function externalAccountInquiry($data) {
        $accountInquiry = new AccountInquiry($this->provider);
        $result = $accountInquiry->external($data);

        return $result;
    }

    /**
     * Internal account inquiry
     *
     * @param Array $data
     */
    public function internalAccountInquiry($data) {
        $accountInquiry = new AccountInquiry($this->provider);
        $result = $accountInquiry->internal($data);

        return $result;
    }

    /**
     * Transfer intrabank
     *
     * @param Array $data
     */
    public function transfer($data, $method) {
        $transfer = new Transfer($this->provider);
        $result = $transfer->transfer($data, $method);

        return $result;
    }

    /**
     * Payment webhook
     */
    public function payment_webhook() {
        return response()->json([
            'status' => 'ok',
        ]);
    }

    /**
     * Inquiry VA webhook
     */
    public function va_inquiry_webhook() {
        return response()->json([
            'status' => 'ok',
        ]);
    }

    /**
     * VA Payment webhook
     */
    public function va_payment_webhook() {
        return response()->json([
           'status' => 'ok',
        ]);
    }
}
