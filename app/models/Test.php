<?php

namespace App\Models;

use App\Core\Model;
use PDOException;

class Test extends Model
{

    function __construct($db = null)
    {
        parent::__construct('table', $db);
    }
   
}
