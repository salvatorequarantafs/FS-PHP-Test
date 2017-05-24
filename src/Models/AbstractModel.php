<?php

namespace App\Models;

use App\Core\Database;

abstract class AbstractModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }
}