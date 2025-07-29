<?php

namespace App\Http\Controllers\Payment;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\OrderPayment;
use App\Models\Backend\SubscriptionPlan;
use App\Models\User;
use DGvai\SSLCommerz\SSLCommerz;
use Illuminate\Http\Request;

class SSLCommerzController extends Controller
{
    public static function sendOrderRequestToSSLZ($totalAmount, $contentName)
    {
        $sslc = new SSLCommerz();
        $sslc->amount($totalAmount)
            ->trxid(OrderPayment::generateOrderNumber())
            ->product($contentName)
            ->customer(ViewHelper::loggedUser()->name, ViewHelper::loggedUser()->email ?? 'user@demo.com', ViewHelper::loggedUser()->mobile);
        return $sslc->make_payment();
    }

    public function paymentSuccess(Request $request)
    {

        try {
            $validate = SSLCommerz::validate_payment($request);
            if($validate)
            {
                $requestData = (object) \session()->get('requestData');
                $user = User::find($requestData->user_id);
                $subscriptionPlan = SubscriptionPlan::find($requestData->subscription_id);
                $orderPayment = OrderPayment::placeOrderPayment($user, $subscriptionPlan, $request, $requestData);
                $placeOrderOnUser = ViewHelper::placeSubscriptionOrder($user->id, $subscriptionPlan->id);
                if ($placeOrderOnUser['status'] == 'success')
                {
                    if (str()->contains(url()->current(), '/api/'))
                    {
                        return response()->json(['message' => 'You purchased the plan successfully.', 'invoice_number' => $orderPayment['invoice_number']], 200);
                    }
                    if (!empty($requestData->redirect_url))
                    {
                        return redirect($requestData->redirect_url)->with('success', 'You Purchased the '.$subscriptionPlan->title ?? 'Subscription Plan'.' successfully.');
                    }
                    return redirect()->route('/')->with('success', 'You Ordered the '.$subscriptionPlan->title.' plan successfully.');
                } else {
                    if (str()->contains(url()->current(), '/api/'))
                    {
                        return response()->json(['message' => 'Order could not placed . Please try again', 'status' => 'error'], 400);
                    }
                    if (!empty($requestData->redirect_url))
                    {
                        return redirect($requestData->redirect_url)->with('success', 'Order could not placed . Please try again.');
                    }
                }

            }
        } catch (\Exception $exception)
        {
            return $exception->getMessage();
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
    }

    public function paymentFailure (Request $request)
    {
        $requestData = \session()->get('requestData');
        return redirect($requestData['redirect_url'])->with('error', 'Omething de');
    }
    public function paymentCancel (Request $request)
    {
        $requestData = \session()->get('requestData');
        return redirect($requestData['details_url'])->with('error', 'The request was canceled by the user. Payment not completed.');
    }
    public function ipn (Request $request)
    {

    }
}
