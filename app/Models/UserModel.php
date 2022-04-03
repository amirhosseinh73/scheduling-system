<?php 

namespace App\Models;

class UserModel extends ParentModel
{
    protected $DBGroup          = 'default';

    protected $useAutoIncrement = TRUE;
    protected $useSoftDeletes   = TRUE;
    protected $useTimestamps    = TRUE;

    protected $table            = 'user';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'object';

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    protected $allowedFields    = [
        "firstname",
        "lastname",
        "email",
        "gender",
        "age",
        "image",
        "status",
        "is_admin",
        "recover_pass_at",
        "last_login",
        "token",
        "password",
    ];
}