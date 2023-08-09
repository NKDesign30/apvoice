<?php

namespace apo\bonago\models;

use awsm\wp\libraries\Model;

class Voucher extends Model
{
    protected $fillable = [
        'voucher_code',
        'assigned',
        'redeemed',
        'assigned_at',
        'redeemed_at',
        'expires_at',
    ];

    protected $unique = [
        'voucher_code',
    ];

    private $searchParam;

	public function __construct() 
	{
        parent::__construct('bonago_voucher_codes');
    }


    /**
     * Query method for the admin view.
     * Returns voucher codes by the current filter and query params.
     * @param array $queryParams
     */
    public function showByQueryParams($queryParams)
    {
        if ( !array_key_exists('filter', $queryParams) || !method_exists($this, $queryParams['filter']) ) {
            return [];
        }

        $this->setSearchParam($queryParams['s']);

        return call_user_func( [ $this, $queryParams['filter'] ] );
    }


    /**
     * Filter method: all.
     */
    public function all() 
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
     * Filter method: available.
     */
    public function available() 
    {
        $query = $this->db->select("
            {$this->defaultQuery()}
            WHERE 
                `{$this->table}`.`assigned` = 0 AND 
                `{$this->table}`.`redeemed` = 0 AND 
                {$this->searchQuery()}
            {$this->defaultOrder()}
        ");
        return $query;
    }


    /**
     * Filter method: assigned.
     */
    public function assigned() 
    {
        $query = $this->db->select("
            {$this->defaultQuery()}
            WHERE 
                `{$this->table}`.`assigned` = 1 AND 
                {$this->searchQuery()}
            {$this->defaultOrder()}
        ");
        return $query;
    }


    /**
     * Filter method: redeemed.
     */
    public function redeemed() 
    {
        $query = $this->db->select("
            {$this->defaultQuery()}
            WHERE 
                `{$this->table}`.`redeemed` = 1 AND 
                {$this->searchQuery()}
            {$this->defaultOrder()}
        ");
        return $query;
    }


    /**
     * Returns the first available voucher
     */
    public function showOneAvailable()
    {
        $query = $this->db->selectRow("
            {$this->defaultQuery()}
            WHERE 
                `{$this->table}`.`assigned` = 0 AND 
                `{$this->table}`.`redeemed` = 0 AND 
                `{$this->table}`.`expires_at` >= NOW() 
            ORDER BY `{$this->table}`.`created_at` LIMIT 1
        ");
        return $query;
    }


    /**
     * Returns all vouchers for the given user
     */
    public function showUsersVouchers()
    {
        $query = $this->db->select("
            {$this->defaultQuery()}
            WHERE 
                `{$this->table}`.`assigned` = 1 AND 
                `{$this->prefix}bonago_voucher_user`.`user_id` =  {$this->userId()} 
        ");
        return $query;
    }


    /**
     * Returns one voucher by code for the given user
     * @param string $voucherCode
     */
    public function showUsersVoucher( $voucherCode )
    {
        $query = $this->db->selectRow("
            {$this->defaultQuery()}
            WHERE 
                `{$this->table}`.`voucher_code` = '{$voucherCode}' AND 
                `{$this->table}`.`assigned` = 1 AND 
                `{$this->prefix}bonago_voucher_user`.`user_id` =  {$this->userId()} 
            LIMIT 1
        ");
        return $query;
    }


     /**
     * Mark the given voucher as assigned
     * @param int $id
     */
    public function assign( $id )
    {
        return $this->update( 
            [
                'assigned' => 1,
                'assigned_at' => date('Y-m-d H:i:s', time()),
            ], 
            ['id' => $id] );
    }

    
    /**
     * Mark the given voucher as redeemed
     * @param int $id
     */
    public function redeem( $id )
    {
        return $this->update( 
            [
                'redeemed' => 1,
                'redeemed_at' => date('Y-m-d H:i:s', time()),
            ], 
            ['id' => $id] );
    }


    /**
     * Count all rows from the `bonago_voucher_codes` table
     */
    public function countAll()
    {
        return $this->db->countRows($this->table);
    }


    /**
     * Count all available vouchers
     */
    public function countAvailables()
    {
        return $this->db->countRows($this->table, "assigned = 0 AND redeemed = 0");
    }


    /**
     * Count all assigned vouchers
     */
    public function countAssigned()
    {
        return $this->db->countRows($this->table, "assigned = 1");
    }


    /**
     * Count all redeemed vouchers
     */
    public function countRedeemed()
    {
        return $this->db->countRows($this->table, "redeemed = 1");
    }


    /**
     * Returns a collection of all countable types
     */
    public function getAmountCollection()
    {
        return [
            'all' => $this->countAll(),
            'available' => $this->countAvailables(),
            'assigned' => $this->countAssigned(),
            'redeemed' => $this->countRedeemed(),
        ];
    }


    /**
     * Checks if the voucher exists
     * @param string $voucherCode
     */
    public function exists( $voucherCode )
    {
        return $this->whereFirst(['voucher_code' => $voucherCode]);
    }


    /**
     * Checks if the expiration date for the given voucher has changed
     * @param int $id
     * @param datestring Y-m-d $expiresAt
     */
    public function hasExpiresAtDateChanged( $id, $expiresAt )
    {
        return $this->showOne($id)->expires_at !== $expiresAt;
    }

    /**
     * Removes all ids from the wp_bonago_voucher_codes table
     */
    public function removeBulk($ids)
    {
        $countRemovedVouchers = 0;
        foreach ($ids as $id) {
            $removedVoucherId = $this->db->delete( $this->table, [ 'id' => $id ] );
            if($removedVoucherId > 0) {
                $countRemovedVouchers++;
            }
        }

        return $countRemovedVouchers;
    }


    /**
     * Returns a default query state for the given model.
     * It's the most commonly used initial query 
     */
    protected function defaultQuery()
    {
        return "
            SELECT 
                `{$this->table}`.*, `{$this->prefix}bonago_voucher_user`.`user_id` 
            FROM `{$this->table}`
                LEFT JOIN 
                    `{$this->prefix}bonago_voucher_user` 
                ON `{$this->prefix}bonago_voucher_user`.`voucher_code_id` =  `{$this->table}`.`id`
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
        return "`{$this->table}`.`voucher_code` LIKE '%{$this->searchParam}%'";
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
