<?php 

namespace App\Models;

class TokenModel extends ParentModel
{
    protected $DBGroup          = 'default';

    protected $useAutoIncrement = TRUE;
    protected $useSoftDeletes   = FALSE;
    protected $useTimestamps    = TRUE;

    protected $table            = 'token';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'object';

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    // protected $deletedField     = 'deleted_at';

    protected $allowedFields    = [
        "token",
        "ip_address",
        "user_agent",
        "expire_at",
    ];
}
