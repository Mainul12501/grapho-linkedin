<?php

namespace App\Services;

use DGvai\SSLCommerz\SSLCommerz as BaseSSLCommerz;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class SSLCommerzService extends BaseSSLCommerz
{
    public function make_payment($initiate_only = false)
    {
        try {
            $client = new Client([
                'base_uri' => $this->getDomainUrl(),
                'timeout' => 60,
                'verify' => $this->getVerificationStatus()
            ]);

            try {
                $response = $client->post(config('sslcommerz.path.endpoint.make_payment'), [
                    'form_params' => $this->makeBody()
                ]);
                $output = json_decode($response->getBody()->getContents());

                if ($output->status == 'FAILED') {
                    return $output->failedreason;
                } else {
                    return $initiate_only
                        ? json_encode(['status' => 'success', 'data' => $output->GatewayPageURL, 'logo' => $output->storeLogo])
                        : redirect()->to($output->GatewayPageURL);
                }
            } catch (RequestException $ex) {
                echo Message::toString($ex->getRequest());
                if ($ex->hasResponse()) {
                    echo Message::toString($ex->getResponse());
                }
            }
        } catch (ClientException $ex) {
            echo Message::toString($ex->getRequest());
            echo Message::toString($ex->getResponse());
        }
    }

    public static function validate_payment($request)
    {
        if (self::SSLC_Hash_Verify_Fixed($request)) {
            $validation_id = $request->val_id;
            $storeid = config('sslcommerz.store.id');
            $storepass = config('sslcommerz.store.password');

            try {
                $client = new Client([
                    'base_uri' => config('sslcommerz.sandbox') ? config('sslcommerz.path.domain.sandbox') : config('sslcommerz.path.domain.live'),
                    'timeout' => 60,
                    'verify' => !config('sslcommerz.localhost')
                ]);

                try {
                    $response = $client->get(config('sslcommerz.path.endpoint.order_validate'), ['query' => [
                        'val_id' => $validation_id,
                        'store_id' => $storeid,
                        'store_passwd' => $storepass,
                        'format' => 'json'
                    ]]);

                    $output = json_decode($response->getBody()->getContents());

                    if ($output->status == 'VALID' || $output->status == 'VALIDATED') {
                        if ($request->currency == 'BDT') {
                            if ($request->tran_id == $output->tran_id && $request->amount == $output->amount) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            if ($request->tran_id == $output->tran_id && $request->amount == $output->currency_amount) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    } else {
                        return false;
                    }
                } catch (RequestException $ex) {
                    echo Message::toString($ex->getRequest());
                    if ($ex->hasResponse()) {
                        echo Message::toString($ex->getResponse());
                    }
                }
            } catch (ClientException $ex) {
                echo Message::toString($ex->getRequest());
                echo Message::toString($ex->getResponse());
            }
        }
    }

    private static function SSLC_Hash_Verify_Fixed($request)
    {
        if (isset($request) && isset($request->verify_sign) && isset($request->verify_key)) {
            $pre_define_key = explode(',', $request->verify_key);
            $new_data = [];

            if (!empty($pre_define_key)) {
                foreach ($pre_define_key as $value) {
                    $new_data[$value] = ($request->$value);
                }
            }

            $new_data['store_passwd'] = md5(config('sslcommerz.store.password'));
            ksort($new_data);
            $hash_string = "";

            foreach ($new_data as $key => $value) {
                $hash_string .= $key . '=' . ($value) . '&';
            }

            $hash_string = rtrim($hash_string, '&');

            if (md5($hash_string) == $request->verify_sign) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function refund(string $bank_tran_id, $refund_amount, $refund_remarks = 'Bad Product')
    {
        try {
            $client = new Client([
                'base_uri' => config('sslcommerz.sandbox') ? config('sslcommerz.path.domain.sandbox') : config('sslcommerz.path.domain.live'),
                'timeout' => 60,
                'verify' => !config('sslcommerz.localhost')
            ]);

            try {
                $response = $client->get(config('sslcommerz.path.endpoint.refund_payment'), ['query' => [
                    'bank_tran_id' => $bank_tran_id,
                    'store_id' => config('sslcommerz.store.id'),
                    'store_passwd' => config('sslcommerz.store.password'),
                    'refund_amount' => $refund_amount,
                    'refund_remarks' => $refund_remarks,
                    'format' => 'json'
                ]]);

                $output = json_decode($response->getBody()->getContents());

                if ($output->APIConnect == 'INVALID_REQUEST') {
                    $answer = ['status' => false, 'message' => 'Invalid data imputed to call the API'];
                } else if ($output->APIConnect == 'FAILED') {
                    $answer = ['status' => false, 'message' => 'API Authentication Failed'];
                } else if ($output->APIConnect == 'INACTIVE') {
                    $answer = ['status' => false, 'message' => 'API User/Store ID is Inactive'];
                } else if ($output->APIConnect == 'DONE') {
                    $answer = ['status' => true, 'refund_state' => $output->status, 'ref_id' => $output->refund_ref_id, 'output' => $output];
                }

                return json_decode(json_encode($answer));
            } catch (RequestException $ex) {
                echo Message::toString($ex->getRequest());
                if ($ex->hasResponse()) {
                    echo Message::toString($ex->getResponse());
                }
            }
        } catch (ClientException $ex) {
            echo Message::toString($ex->getRequest());
            echo Message::toString($ex->getResponse());
        }
    }

    public static function query_refund($ref_id)
    {
        try {
            $client = new Client([
                'base_uri' => config('sslcommerz.sandbox') ? config('sslcommerz.path.domain.sandbox') : config('sslcommerz.path.domain.live'),
                'timeout' => 60,
                'verify' => !config('sslcommerz.localhost')
            ]);

            try {
                $response = $client->get(config('sslcommerz.path.endpoint.refund_status'), ['query' => [
                    'refund_ref_id' => $ref_id,
                    'store_id' => config('sslcommerz.store.id'),
                    'store_passwd' => config('sslcommerz.store.password')
                ]]);

                $output = json_decode($response->getBody()->getContents());

                if ($output->APIConnect == 'INVALID_REQUEST') {
                    $answer = ['status' => false, 'message' => 'Invalid data imputed to call the API'];
                } else if ($output->APIConnect == 'FAILED') {
                    $answer = ['status' => false, 'message' => 'API Authentication Failed'];
                } else if ($output->APIConnect == 'INACTIVE') {
                    $answer = ['status' => false, 'message' => 'API User/Store ID is Inactive'];
                } else if ($output->APIConnect == 'DONE') {
                    $answer = ['status' => true, 'refund_state' => $output->status, 'ref_id' => $output->refund_ref_id, 'output' => $output];
                }

                return json_decode(json_encode($answer));
            } catch (RequestException $ex) {
                echo Message::toString($ex->getRequest());
                if ($ex->hasResponse()) {
                    echo Message::toString($ex->getResponse());
                }
            }
        } catch (ClientException $ex) {
            echo Message::toString($ex->getRequest());
            echo Message::toString($ex->getResponse());
        }
    }

    public static function query_transaction($trxid)
    {
        try {
            $client = new Client([
                'base_uri' => config('sslcommerz.sandbox') ? config('sslcommerz.path.domain.sandbox') : config('sslcommerz.path.domain.live'),
                'timeout' => 60,
                'verify' => !config('sslcommerz.localhost')
            ]);

            try {
                $response = $client->get(config('sslcommerz.path.endpoint.transaction_status'), ['query' => [
                    'tran_id' => $trxid,
                    'store_id' => config('sslcommerz.store.id'),
                    'store_passwd' => config('sslcommerz.store.password')
                ]]);

                $output = json_decode($response->getBody()->getContents());

                if ($output->APIConnect == 'INVALID_REQUEST') {
                    $answer = ['status' => false, 'message' => 'Invalid data imputed to call the API'];
                } else if ($output->APIConnect == 'FAILED') {
                    $answer = ['status' => false, 'message' => 'API Authentication Failed'];
                } else if ($output->APIConnect == 'INACTIVE') {
                    $answer = ['status' => false, 'message' => 'API User/Store ID is Inactive'];
                } else if ($output->APIConnect == 'DONE') {
                    $answer = ['status' => true, 'output' => $output];
                }

                return json_decode(json_encode($answer));
            } catch (RequestException $ex) {
                echo Message::toString($ex->getRequest());
                if ($ex->hasResponse()) {
                    echo Message::toString($ex->getResponse());
                }
            }
        } catch (ClientException $ex) {
            echo Message::toString($ex->getRequest());
            echo Message::toString($ex->getResponse());
        }
    }

    private function getDomainUrl()
    {
        return config('sslcommerz.sandbox')
            ? config('sslcommerz.path.domain.sandbox')
            : config('sslcommerz.path.domain.live');
    }

    private function getVerificationStatus()
    {
        return !config('sslcommerz.localhost');
    }
}
