<?php 

namespace App\Models;

use CodeIgniter\Model;

class ParentModel extends Model
{
    // protected $skipValidation = false;
    /**
     * Only gets non-deleted rows (deleted = 0)
     * $activeUsers = $userModel->findAll();
     *
     * Gets all rows
     * $allUsers = $userModel->withDeleted()->findAll();
     * $deletedUsers = $userModel->onlyDeleted()->findAll();
     */


    /**
     * Summary.
     * return items where status is TRUE,
     * return Active items
     * @param bool $return_all FALSE | TRUE
     * @param int $limit
     * @param int $offset
     * @return object|array|null
     * @author amirhosein hasani
     */
    public function CustomFindAll( bool $return_all = FALSE, int $limit = 0, int $offset = 0)
    {
        if ( $return_all ) return $this->findAll( $limit, $offset );
        
        return $this->where( "status", TRUE )->findAll( $limit, $offset );
    }

    /**
     * Summary.
     * return item where status is TRUE,
     * return Active item
     * @param bool $return_all FALSE | TRUE
     * @param array|int|string|null $id — One primary key or an array of primary keys
     * @return object|array|null
     * @author amirhosein hasani
     */
    public function CustomFind( bool $return_all = FALSE, $id = NULL)
    {
        if ( $return_all ) return $this->find( $id );
        
        return $this->where( "status", TRUE )->find( $id );
    }

    /**
     * Summary.
     * return item where status is TRUE,
     * return Active item
     * @param bool $return_all FALSE | TRUE
     * @return object|array|null
     * @author amirhosein hasani
     */
    public function CustomFirst( bool $return_all = FALSE)
    {
        if ( $return_all ) return $this->first();
        
        return $this->where( "status", TRUE )->first();
    }
}