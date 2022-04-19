<?php

namespace App\Controllers\Dashboard;

use App\Controllers\ParentController;
use App\Libraries\Alert;
use App\Libraries\TextLibrary;
use App\Models\BookingModel;
use App\Models\PaymentRequestModel;

class ReservationController extends ParentController {
    public function index() {
        $user_info = get_user_info();

        $data_page = array(
            "title_head"        => TextLibrary::title( "reservation" ),
            "description_head"  => TextLibrary::description( "company_name" ),
            "page_name"         => "reservation_index",
            "user_info"         => $user_info,
        );

        return $this->renderPageDashboard( "reservation-index", $data_page );
    }

    public function submit()
    {
        $user_info = get_user_info();

        $booking_ID = $this->request->getPost( "ID" );

        if ( ! exists( $booking_ID ) ) return Alert::Error( -1 );

        $booking_model         = new BookingModel();
        $payment_request_model = new PaymentRequestModel();

        $select_booking = $booking_model
            ->where( "ID", $booking_ID )
            ->first();

        if ( ! exists( $select_booking ) ) return Alert::Error( -1 );

        require APPPATH . "/Libraries/ZibalFunctions.php";

        $zibal_parameters = array(
            "merchant"      => ZIBAL_MERCHANT_KEY,
            "callbackUrl"   => ZIBAL_CALLBACK_URL,
            "amount"        => $select_booking->price,
            "orderId"       => time(),
        );

        $zibal_response = postToZibal('request', $zibal_parameters);

        if ( intval( $zibal_response->result ) !== 100) return Alert::Error( 100, resultCodes( $zibal_response->result ) );

        $data_insert = array(
            "user_ID"  => $user_info->ID,
            "amount"   => $zibal_parameters[ "amount" ],
            "order_ID" => $zibal_parameters[ "orderId" ],
            "time"     => date( "Y-m-d H:i:s" ),
        );
        
        try {
            $payment_request_model->insert( $data_insert );
        } catch( \Exception $e ) {
            return Alert::Error( 100, $e );
        }
        
        return Alert::Success( 204, array(), ZIBAL_GATEWAY_URL( $zibal_response->trackId ) );
    }

    public function callbackPayment() {
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