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
        "username",
        "firstname",
        "lastname",
        "email",
        "gender",
        "type_user",
        "status",
        "is_admin",
        "image",
        "verifile_code_mobile",
        "verifile_code_email",
        "mobile_verified_at",
        "email_verified_at",
        "last_login_at",
        "recovery_pass_at",
        "change_pass_at",
        "token",
        "password",
    ];
}