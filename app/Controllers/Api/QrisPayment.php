<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class WebhookWA extends BaseController
{
    public function receive()
    {
        $json = $this->request->getJSON();



        return $this->response->setJSON(['status' => 'received', 'message' => $json]);
    }
}