<?php

namespace App\Traits;

trait ResponseTrait{

    public function response($message,$notif){
        return [
            'notif-'.$notif=>$message,
        ];
    }

    public function actionRejected(){
        return back()->with('notif-warning','tidak bisa melakukan aksi ini!');
    }

    public function success(){
        return 'notif-success';
    }
    public function warning(){
        return 'notif-warning';
    }

    public function msgSuccess($table){
        return 'notif-success';
    }
    public function msgWarning($table){
        return 'notif-warning';
    }


    public function responseMessage($type,$table=null){
        switch ($type) {
            case 'save':
                $this->generateResponse($this->responseList[$type],$table);
                break;

            default:
                # code...
                break;
        }
    }

    private function generateResponse($response,$table){

        return $table ? str_replace('$table',$table) : $response;

    }

    public $responseList = [
        'save_success' => 'Data berhasil telah di simpan'
    ];
}
