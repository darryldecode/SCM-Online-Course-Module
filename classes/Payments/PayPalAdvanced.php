<?php namespace SCM\Classes\Payments;

use Carbon\Carbon;
use Curl\Curl;
use SCM\Classes\Log;

class PayPalAdvanced {

    protected $endPointUrl;

    protected $user;

    protected $vendor;

    protected $partner;

    protected $pwd;

    protected $mode;

    protected $amount;

    protected $createSecureToken;

    protected $trxType;

    protected $secureTokenID;

    protected $cancelURL; // if layout A and B only

    protected $emailCustomer;

    protected $errorURL;

    protected $returnURL;

    protected $silentPostURL;

    protected $urlMethod;

    protected $parmList;

    /**
     * RESPONSES
     */
    protected $responseString;

    protected $responseCurlErrorCode;

    protected $responseRESULT;

    protected $responseMSG;

    protected $responseSECURETOKEN;

    protected $responseSECURETOKENID;

    protected $responseIsApproved = false;

    public function setEndPointUrl($endPointURL)
    {
        $this->endPointUrl = $endPointURL;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setPartner($partner)
    {
        $this->partner = $partner;
    }

    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    public function setPWD($pwd)
    {
        $this->pwd = $pwd;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setCreateSecureToken($createSecureToken = 'Y')
    {
        $this->createSecureToken = $createSecureToken;
    }

    public function setTrxType($trxType = 'S')
    {
        $this->trxType = $trxType;
    }

    public function setSecureTokenID($secureTokenID)
    {
        $this->secureTokenID = $secureTokenID;
    }

    public function setCancelUrl($cancelUrl)
    {
        $this->cancelURL = $cancelUrl;
    }

    public function setEmailCustomer($emailCustomer = false)
    {
        $this->emailCustomer = $emailCustomer;
    }

    public function setErrorUrl($errorURL)
    {
        $this->errorURL = $errorURL;
    }

    public function setReturnUrl($returnURL)
    {
        $this->returnURL = $returnURL;
    }

    public function setSilentPostUrl($silentPostURL)
    {
        $this->silentPostURL = $silentPostURL;
    }

    public function setUrlMethod($method = 'GET')
    {
        $this->urlMethod = $method;
    }

    public function setParmList($paramList)
    {
        $this->parmList = $paramList;
    }

    public function callPayFlowServer()
    {
        $partner = $this->partner;
        $vendor = $this->vendor;
        $user = $this->user;
        $pwd = $this->pwd;
        $trxType = $this->trxType;
        $amount = $this->amount;
        $createSecureToken = $this->createSecureToken;
        $secureTokenID = $this->secureTokenID;

        $postData = "PARTNER={$partner}&VENDOR={$vendor}&USER={$user}&PWD={$pwd}&TRXTYPE={$trxType}&AMT={$amount}&CREATESECURETOKEN={$createSecureToken}&SECURETOKENID={$secureTokenID}";

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, 'https://payflowpro.paypal.com');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_POST, true);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $postData);

        $res = curl_exec($curl);

        curl_close($curl);

        // log this request
        $dateNow = Carbon::now();
        $log = Log::getInstance();
        $log->systemLog("\n\nPayPal Curl request has been performed.\nRequest Response: {$res}. \nDate: {$dateNow}");

        // put the original response string
        $this->responseString = $res;

        // parse
        parse_str($res, $PPAResponse);

        // if approved
        if($PPAResponse['RESULT']==0)
        {

            $this->responseIsApproved = true;
            $this->responseMSG = $PPAResponse['RESPMSG'];
            $this->responseSECURETOKEN = $PPAResponse['SECURETOKEN'];
            $this->responseSECURETOKENID = $PPAResponse['SECURETOKENID'];
            return $this;

        } else {

            $this->responseIsApproved = false;
            return $this;
        }
    }

    /**
     * check if the call was approved
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->responseIsApproved;
    }

    public function getResponseMsg()
    {
        return $this->responseMSG;
    }

    public function getResponseSecureToken()
    {
        return $this->responseSECURETOKEN;
    }

    public function getResponseSecureTokenID()
    {
        return $this->responseSECURETOKENID;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function getEndPointURL()
    {
        return $this->endPointUrl;
    }

    public function getResponseString()
    {
        return $this->responseString;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function getPartner()
    {
        return $this->partner;
    }

    public function getPassword()
    {
        return $this->pwd;
    }

}