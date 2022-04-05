<?php 

namespace App\Models;

class BookingTimeModel extends ParentModel
{
    protected $DBGroup          = 'default';

    protected $useAutoIncrement = TRUE;
    protected $useSoftDeletes   = TRUE;
    protected $useTimestamps    = TRUE;

    protected $table            = 'booking_time';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'object';

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    protected $allowedFields    = [
        "user_ID",
        "type",
        "date",
        "start",
        "end",
        "time",
        "number_reserve",
        "number_reserved",
    ];
}
