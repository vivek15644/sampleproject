<?php

use Phalcon\Mvc\Model;

class User extends Model {

    public function insertKey($data) {
        try {
            $data = [
                'f_name' => $data->request->user_info->f_name,
                'l_name' => $data->request->user_info->l_name,
                'mdn' => $data->request->user_info->mdn,
            ];
            if($this->save($data)==FALSE){
                foreach ($this->getMessages() as $message){
                    throw new Exception($message->getMessage());
                }
            }
            return [
                'response_code' => 0,
                'response_message' => "Success",
            ];;
        } catch (Exception $e) {
            return [
                'response_code' => 612,
                'response_message' => $e->getMessage(),
            ];
        }
    }

}
