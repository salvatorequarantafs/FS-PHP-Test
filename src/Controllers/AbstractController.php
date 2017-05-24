<?php

namespace App\Controllers;

abstract class AbstractController
{
    protected function jsonResponse($status, $data)
    {
        header('Content-type: application/json');
        echo json_encode([
            'Status' => $status,
            'Data' => $data
        ]);        
    }
}