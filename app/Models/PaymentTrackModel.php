<?php 

namespace App\Models;

class PaymentTrackModel extends ParentModel
{
    protected $DBGroup          = 'default';

    protected $useAutoIncrement = TRUE;
    protected $useSoftDeletes   = FALSE;
    protected $useTimestamps    = TRUE;

    protected $table            = 'payment_track';
    protected $primaryKey       = 'ID';
    protected $returnType       = 'object';

    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    // protected $deletedField     = 'deleted_at';

    protected $allowedFields    = [
        "user_ID",
        "payment_request_ID",
        "amount",
        "order_ID",
        "track_ID",
        "time",
    ];
}
