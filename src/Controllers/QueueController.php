<?php

namespace App\Controllers;

use App\Models\QueueModel;

class QueueController extends AbstractController
{
    public function postQueue()
    {
        $type = \filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
        $service = \filter_input(INPUT_POST, 'service', FILTER_SANITIZE_STRING);
        $firstName = \filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
        $lastName = \filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
        $organization = \filter_input(INPUT_POST, 'organization', FILTER_SANITIZE_STRING);

        switch(true) {    
            case (empty($type) || empty($service)):
                header("HTTP/1.1 400 Bad Request");
                return $this->jsonResponse(
                    'Error',
                    'type and service are mandatory'
                );
            case !in_array($type, ['Citizen', 'Anonymous']):
                header("HTTP/1.1 400 Bad Request");
                return $this->jsonResponse(
                    'Error',
                    'type can be only Citizen or Anonymous'
                );            
            case ($type === 'Citizen') && (empty($firstName) || empty($lastName)):
                header("HTTP/1.1 400 Bad Request");
                return $this->jsonResponse(
                    'Error',
                    'firstName and lastName are mandatory'
                );
            case ($type === 'Anonymous'):
                $firstName = '';
                $lastName = '';

        }

        $model = new QueueModel();
        $result = $model->postQueue($firstName, $lastName, $organization, $type, $service);

        if ($result) {
            return $this->jsonResponse(
                'Success',
                'Data inserted correctly'
            );
        } else {
            return $this->jsonResponse(
                'Error',
                'An error has occurred inserting data'
            );
        }
    }

    public function getQueue()
    {
        $model = new QueueModel();
        $type = \filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
        $result = $model->getQueue($type);

        if (($result === false) || !is_array($result)) {
            return $this->jsonResponse(
                'Error',
                'Impossible to fetch data'
            );
        }

        return $this->jsonResponse(
            'Success',
            $result
        );
    } 
}