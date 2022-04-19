<?php namespace App\Controllers\Payment;

use App\Controllers\BaseController;
use App\Libraries\Errors;
use App\Libraries\ToolsLibrary;
use App\Models\PaymentRecordsModel;
use App\Models\PaymentRequestsModel;
use App\Models\UserModel;

class Pay extends BaseController
{
    public function callbackView()
    {
        return view('result-pay');
    }

    public function callback()
    {
        
    }
}