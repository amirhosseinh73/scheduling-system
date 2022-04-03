<?php 

namespace App\Models;

class PackageModel extends ParentModel
{
    protected $DBGroup          = 'default';

    protected $useAutoIncrement = TRUE;
    protected $useSoftDeletes   = TRUE;
    protected $useTimestamps    = TRUE;

    protected $table            = 'package';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'object';

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    protected $allowedFields    = [
        "title",
        "description",
        "grade",
        "image",
        "price",
        "discount",
        "sales_count",
    ];
}
