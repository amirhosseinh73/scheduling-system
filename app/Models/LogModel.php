<?php 

namespace App\Models;

class LogModel extends ParentModel
{
    protected $DBGroup          = 'default';

    protected $useAutoIncrement = TRUE;
    protected $useSoftDeletes   = FALSE;
    protected $useTimestamps    = TRUE;

    protected $table            = 'log';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'object';

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    // protected $deletedField     = 'deleted_at';

    protected $allowedFields    = [
        "user_ID",
        "data",
    ];
}
