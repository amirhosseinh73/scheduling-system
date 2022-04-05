<?php 

namespace App\Models;

class ExamModel extends ParentModel
{
    protected $DBGroup          = 'default';

    protected $useAutoIncrement = TRUE;
    protected $useSoftDeletes   = TRUE;
    protected $useTimestamps    = TRUE;

    protected $table            = 'exam';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'object';

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    protected $allowedFields    = [
        "title",
        "description",
        "time",
    ];
}
