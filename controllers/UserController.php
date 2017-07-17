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

}
