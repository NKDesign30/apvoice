<?php

namespace apo\pgci\models;

use awsm\wp\libraries\Model;

class PGCI extends Model
{
    protected $fillable = [
        'bga_id',
        'name',
        'house_nr',
        'street',
        'zip_code',
        'city'
    ];

    protected $unique = [
        'bga_id',
    ];

    private $searchParam;

	public function __construct()
	{
        parent::__construct('apovoice_pgci');
    }


    /**
     * Query method for the admin view.
     * Returns pgci codes by the current filter and query params.
     * @param array $queryParams
     */
    public function showByQueryParams($queryParams)
    {
        $this->setSearchParam($queryParams['s']);

        return $this->queryResult();
    }


    /**
     * Returns the query result
     */
    public function queryResult()
    {
        $query = $this->db->select("
            {$this->defaultQuery()}
            WHERE
                {$this->searchQuery()}
            {$this->defaultOrder()}
        ");

        return $query;
    }


    /**
     * Checks if the pgci exists
     * @param string $pgci
     */
    public function exists( $pgci )
    {
        return $this->whereFirst(['bga_id' => $pgci]);
    }


    /**
     * Checks if the name for the given pgci has changed
     * @param int $id
     * @param string $name
     */
    public function hasNameChanged( $id, $name )
    {
        return $this->showOne($id)->name !== $name;
    }

    /**
     * Removes all ids from the wp_apovoice_pgci and wp_apovoice_pgci_user table
     */
    public function removeBulk($ids)
    {
        $countRemovedPharmacies = 0;
        $countPharmacyUserConnection = 0;
        foreach ($ids as $id) {
            $removedPharmacieId = $this->db->delete( $this->table, [ 'id' => $id ] );
            if($removedPharmacieId > 0) {
                $countRemovedPharmacies++;
            }

            $removedPharmacieUserId = $this->db->delete( $this->prefix . 'apovoice_pgci_user', [ 'pharmacy_id' => $id ] );
            if($removedPharmacieUserId > 0) {
                $countPharmacyUserConnection++;
            }
        }

        return [
            'removedPharmacies' => $countRemovedPharmacies,
            'removedPharmacyUserConnection' => $countPharmacyUserConnection
        ];
    }


    /**
     * Returns a default query state for the given model.
     * It's the most commonly used initial query
     */
    protected function defaultQuery()
    {
        return "
            SELECT
                `{$this->table}`.*
            FROM `{$this->table}`
        ";
    }


    /**
     * Returns a default query order for the given model.
     */
    protected function defaultOrder()
    {
        return "ORDER BY `{$this->table}`.`created_at` DESC";
    }


    /**
     * Adds a search query for the voucher code
     */
    protected function searchQuery()
    {
        return "
            `{$this->table}`.`bga_id` LIKE '%{$this->searchParam}%' OR
            `{$this->table}`.`name` LIKE '%{$this->searchParam}%'
        ";
    }


    /**
     * Sets the search param
     * @param string $searchParam
     */
    private function setSearchParam($searchParam)
    {
        if( !is_null($searchParam) ) {
            $this->searchParam = esc_sql($searchParam);
        } else {
            $this->searchParam = null;
        }
        return $this;
    }

}
