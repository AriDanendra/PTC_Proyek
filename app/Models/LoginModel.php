<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama', 'username', 'password', 'role', 'fingerprint_id'];
}
