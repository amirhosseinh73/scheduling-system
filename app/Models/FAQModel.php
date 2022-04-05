<?php 

namespace App\Models;

class FAQModel extends ParentModel
{
    protected $DBGroup          = 'default';

    protected $useAutoIncrement = TRUE;
    protected $useSoftDeletes   = TRUE;
    protected $useTimestamps    = TRUE;

    protected $table            = 'faq';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'object';

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    protected $allowedFields    = [
        "question",
        "answer",
        "status",
    ];
}
