<?php

namespace apo\pun\models;

use awsm\wp\libraries\Model;

class PUN extends Model
{
    protected $fillable = [
        'pharmacy_unique_number',
        'name',
        'role_id' // Hinzugefügt role_id zum $fillable Array
    ];

    protected $unique = [
        'pharmacy_unique_number',
    ];

    private $searchParam;

    public function __construct()
    {
        parent::__construct('apovoice_pharmacies');
    }

    public function showByQueryParams($queryParams)
    {
        $this->setSearchParam($queryParams['s']);
        return $this->queryResult();
    }

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

    public function exists($pun)
    {
        return $this->whereFirst(['pharmacy_unique_number' => $pun]);
    }

    public function hasNameChanged($id, $name)
    {
        return $this->showOne($id)->name !== $name;
    }

    public function removeBulk($ids)
    {
        $countRemovedPharmacies = 0;
        $countPharmacyUserConnection = 0;
        foreach ($ids as $id) {
            $removedPharmacieId = $this->db->delete($this->table, ['id' => $id]);
            if ($removedPharmacieId > 0) {
                $countRemovedPharmacies++;
            }
            $removedPharmacieUserId = $this->db->delete($this->prefix . 'apovoice_pharmacy_user', ['pharmacy_id' => $id]);
            if ($removedPharmacieUserId > 0) {
                $countPharmacyUserConnection++;
            }
        }
        return [
            'removedPharmacies' => $countRemovedPharmacies,
            'removedPharmacyUserConnection' => $countPharmacyUserConnection
        ];
    }

    protected function defaultQuery()
    {
        return "
            SELECT 
                `{$this->table}`.* 
            FROM `{$this->table}` 
        ";
    }

    protected function defaultOrder()
    {
        return "ORDER BY `{$this->table}`.`created_at` DESC";
    }

    protected function searchQuery()
    {
        return "
            `{$this->table}`.`pharmacy_unique_number` LIKE '%{$this->searchParam}%' OR 
            `{$this->table}`.`name` LIKE '%{$this->searchParam}%'
        ";
    }

    private function setSearchParam($searchParam)
    {
        if (!is_null($searchParam)) {
            $this->searchParam = esc_sql($searchParam);
        } else {
            $this->searchParam = null;
        }
        return $this;
    }

    /**
     * Create a new PUN record in the database.
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        // Fügen Sie die Daten in die Datenbank ein und geben Sie das Ergebnis zurück
        return $this->db->insert($this->table, $data);
    }
}
