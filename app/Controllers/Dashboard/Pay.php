<?php namespace App\Controllers\Payment;

use App\Controllers\BaseController;
use App\Libraries\Errors;
use App\Libraries\ToolsLibrary;
use App\Models\PaymentRecordsModel;
use App\Models\PaymentRequestsModel;
use App\Models\UserModel;

class Pay extends BaseController
{
    public function index()
    {
       //http_response_code(405);
        header('Content-Type: application/json');
        $code = 1000;
        die(json_encode(["errorCode" => $code, "errorMessage" => Errors::Error_message($code)], JSON_UNESCAPED_UNICODE));
    }

    public function view()
    {
        return view('pay');
    }

    public function request_pay()
    {
        if ($this->request->getMethod(true) == 'GET' && $this->validate([
                'id' => 'required|min_length[1]',
            ])) {
            $session = \Config\Services::session();
            $id = $this->request->getGet('id');//must change
            $token_session = [
                'year' => convertFaNumberToEn(jdate('Y')),
                'month' => convertFaNumberToEn(jdate('m')),
                'day' => convertFaNumberToEn(jdate('d')),
            ];
            $session->set($token_session);
            $session->setTempdata('token_pay_student', $id, 1800);
            return redirect()->to(base_url('/payment/pay/view'));
        } else {
           //http_response_code(405);
            header('Content-Type: application/json');
            $code = 1000;
            die(json_encode(["errorCode" => $code, "errorMessage" => Errors::Error_message($code)], JSON_UNESCAPED_UNICODE));
        }
    }

    public function request_pay_two()
    {
        if ($this->request->getMethod(true) == 'GET' && $this->validate([
                'package_id' => 'required|min_length[1]|max_length[1]',
            ])) {
            $session = \Config\Services::session();
            $package_id = $this->request->getGet('package_id');
            $amount = 50000;
            $storage = 5242880;
            if ($package_id == 1) {
                $amount = 50000;
                $storage = 1073741824;
            } elseif ($package_id == 2) {
                $amount = 100000;
                $storage = 3221225472;
            } elseif ($package_id == 3) {
                $amount = 150000;
                $storage = 5368709120;
            }
            require 'ZibalFunctions.php';
            $session->set(['storage' => $storage]);
            $id = $session->get('token_pay_student');
            if (isset($id) && !empty($id)) {
                //$mobile = $sel_user['mobile'];

                $parameters = array(
                    "merchant" => '5fbcf9ef18f9344448fe61ff',
                    "callbackUrl" => base_url('payment/pay/callback'),
                    "amount" => $amount,
                    "orderId" => time(),
                    //"mobile" => $mobile
                );

                $response = postToZibal('request', $parameters);
                if ($response->result == 100) {
                    $users = new UserModel();
                    $old_storage = $users
                        ->where('id', $id)
                        ->first()['purchased_space'];
                    $payment_requests = new PaymentRequestsModel();
                    $year = $session->get('year');
                    $month = $session->get('month');
                    $day = $session->get('day');
                    $order_date = $year . '/' . $month . '/' . $day;
                    $data_payment_records = [
                        'student_id' => $id,
                        'amount' => $amount,
                        'new_space' => $storage,
                        'old_space' => $old_storage,
                        'date' => $order_date,
                        'orderTime' => time()
                    ];
                    $payment_requests->insert($data_payment_records);
                    $payment_records = new PaymentRecordsModel();
                    $already_payed_today = $payment_records
                        ->select('date')
                        ->where('student_id',$id)
                        ->findAll();
                    $today_payed = false;
                    foreach ($already_payed_today as $today){
                        if ($order_date == $today['date']) {
                            $today_payed = true;
                        }
                    }
                    if ($today_payed == false) {
                        $startGateWayUrl = "https://gateway.zibal.ir/start/" . $response->trackId;
                        return redirect()->to($startGateWayUrl);
                    } else {
                       //http_response_code(405);
                        $responseMessage = 'متاسفیم، در هر روز بیش از یک بار نمیتوانید خرید بسته انجام دهید.';
                        $session->setTempdata('responseMessage',$responseMessage,1800);
                        return redirect()->to(base_url('/payment/pay/view'));
                    }
                } else {
                   //http_response_code(405);
                    $responseMessage = 'متاسفانه خطایی رخ داد بعد از چند دقیقه دوباره امتحان کنید.';
                    $session->setTempdata('responseMessage',$responseMessage,1800);
                    return redirect()->to(base_url('/payment/pay/view'));
                }
            } else {
               //http_response_code(405);
                $responseMessage = 'متاسفانه اطلاعات کاربری اشتباه است، دوباره به نرم افزار برگردید و مجددا امتحان کنید.';
                $session->setTempdata('responseMessage',$responseMessage,1800);
                $session->setTempdata('token_id','false',1800);
                return redirect()->to(base_url('/payment/pay/view'));
                // اینجا باید برگرده به app
            }
        } else {
            $session = \Config\Services::session();
           //http_response_code(405);
            $responseMessage = 'بسته خود را به درستی انتخاب کنید.';
            $session->setTempdata('responseMessage',$responseMessage,1800);
            return redirect()->to(base_url('/payment/pay/view'));
        }
    }

    public function callbackView()
    {
        return view('result-pay');
    }

    public function callback()
    {
        if ($this->request->getMethod(true) == 'GET' && $this->validate([
                'success' => 'required|min_length[1]',
            ])) {
            $session = \Config\Services::session();
            $success = $this->request->getGet('success');
            if ($success == 1) {
                require 'ZibalFunctions.php';
                $id = $session->get('token_pay_student');
                if (isset($id) && !empty($id)) {
                    $trackId = $this->request->getGet('trackId');
                    $orderId = $this->request->getGet('orderId');
                    $new_storage = $session->get('storage');
                    $year = $session->get('year');
                    $month = $session->get('month');
                    $day = $session->get('day');
                    $expire_year = $year + 1;
                    $order_date = $year . '/' . $month . '/' . $day;
                    $expire_date = $expire_year . '/6/1';
                    $parameters = array(
                        "merchant" => "5fbcf9ef18f9344448fe61ff",
                        "trackId" => $trackId
                    );
                    $response = postToZibal('verify', $parameters);
                    if ($response->result == 100) {
                        $paymentRecords = new PaymentRecordsModel();
                        $users = new UserModel();
                        $old_storage = $users
                            ->where('id', $id)
                            ->first()['purchased_space'];
                        $data_payment_records = [
                            'student_id' => $id,
                            'amount' => $response->amount,
                            'new_space' => $new_storage,
                            'old_space' => $old_storage,
                            'date' => $order_date,
                            'tracking_number' => $trackId,
                            'orderTime' => $orderId
                        ];
                        $storage = $new_storage + $old_storage;
                        $data_users = [
                            'status_pay' => 'true',
                            'expired_date_time' => $expire_date,
                            'purchased_space' => $storage
                        ];

                        $paymentRecords->insert($data_payment_records);
                        $users->update($id, $data_users);
                        $session->set(['tracking_number' => $trackId]);
                        return redirect()->to(base_url('/payment/pay/callbackView'));
                    } else {
                       //http_response_code(405);
                        $responseMessage = statusCodes($response->result);
                        $session->setTempdata('responseMessage',$responseMessage,1800);
                        return redirect()->to(base_url('/payment/pay/view'));//
                        // اینجا باید برگرده به app
                    }
                } else {
                   //http_response_code(405);
                    $responseMessage = 'متاسفانه اطلاعات کاربری اشتباه است، دوباره به نرم افزار برگردید و مجددا امتحان کنید';
                    $session->setTempdata('responseMessage',$responseMessage,1800);
                    $session->setTempdata('token_id','false',1800);
                    return redirect()->to(base_url('/payment/pay/view'));
                    // اینجا باید برگرده به app
                }

            } else {
               //http_response_code(405);
                $responseMessage = 'متاسفانه پرداخت شما ناموفق بود، لطفا دوباره تلاش کنید.';
                $session->setTempdata('responseMessage',$responseMessage,1800);
                return redirect()->to(base_url('/payment/pay/view'));
            }
        } else {
           //http_response_code(405);
            $session = \Config\Services::session();
            $responseMessage = 'از جای نادرستی وارد شده اید. دوباره تلاش کنید';
            $session->setTempdata('responseMessage',$responseMessage,1800);
            return redirect()->to(base_url('/payment/pay/view'));
        }
    }
}