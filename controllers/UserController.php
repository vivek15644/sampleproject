<?php

class UserController {

    private $api_request;

    public function __construct($data = '') {
        $this->api_request = $data;
    }

    public function createNewUser() {
        try {
            $obj = new User();
            return $obj->insertKey($this->api_request);
        } catch (Exception $e) {
            return [
                'response_code' => 256,
                'response_description' => $e->getMessage(),
            ];
        }
    }

    private function modifySummaryList($response) {
        $resp_arry = json_decode($response, true);
        $order_list = $resp_arry['response']['order_list'];
        foreach ($order_list as $key => $value) {
            $order_id_arr[$key] = $value['order_id'];
        }
        array_multisort($order_id_arr, SORT_ASC, $order_list);
        return [
            'response_code' => $resp_arry['response_code'],
            'response_description' => $resp_arry['response_description'],
            'response' => [
                'order_list' => $order_list
            ]
        ];
    }

    public function getOrderSummary() {
        try {
            $url = "http://orderservice.com/v1.0/order/summarylist?offset=0&limit=5";
            $headers = [
                "Content-Type: application/json",
                "Accept: application/json",
                "usermdn: 918743854419",
                "Authorisation: ssss",
                "code: ssss",
            ];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($ch);
            $curl_error = curl_error($ch);
            if (!empty($response)) {
                return $this->modifySummaryList($response);
            } else {
                return [
                    'respose_code' => 254,
                    'respose_description' => $curl_error,
                ];
            }
        } catch (Exception $ex) {
            
        }
    }

}
