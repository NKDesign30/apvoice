<?php

namespace awsm\wp\libraries;

use awsm\wp\libraries\DB;
use awsm\wp\libraries\utilities\Auth;

class Model
{
    use Auth;

    public $db;
    public $table;
    public $prefix;
    public $defaultPrefix;

    protected $fillable = [];
    protected $primary = 'id';
    protected $unique = [];

    /**
     * Instantiate the base model class.
     * Add the base table name without any database prefix.
     * 
     * @param String $table 
     * 
     * @return Void
     */
	public function __construct($table) 
	{
        $this->db = DB::instance();
        $this->table = $this->db->wpdb->prefix . $table;
        $this->prefix = $this->db->wpdb->prefix;
        $this->defaultPrefix = $this->db->defaultPrefix;
    }

     /**
     * Get methods
     */
    public function show()
    {
        return $this->db->select('SELECT * FROM ' . $this->table);
    }

    public function showOne($id) 
    {
        return $this->db->selectRow('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);
    }

    public function showLastEntry()
    {
        return $this->db->selectRow('SELECT * FROM ' . $this->table . ' WHERE id = ' . $this->db->lastId());
    }

    public function where($where)
    {
        $where = implode(' AND ', array_map(function($key, $value) {
            return $key . ' = "' . $value . '"';
          }, array_keys($where), $where));
          
        return $this->db->select('SELECT * FROM ' . $this->table . ' WHERE ' . $where);
    }

    public function whereFirst($where)
    {
        return $this->where($where)[0];
    }

    /**
     * Store methods
     */
    public function create($data) 
    {
        $this->extractFillableFields($data);

        $result = $this->db->insert($this->table, (array) $data);
        if($result) {
            return $this->showLastEntry();
        }
        return $this->db->lastError();
    }

    public function createOrUpdate($data)
    {
        $where = $data;
        $this->extractUniqueFields($where);

        if($this->whereFirst($where)) {
            return $this->update($data, $where);
        }
        return $this->create($data);
    }

    /**
     * Update methods
     */
    public function update($data, $where) 
    {
        $this->extractFillableFields($data);

        $this->db->update($this->table, (array) $data, (array) $where);

        if(!$this->db->lastError()) {
            return $this->whereFirst($where);
        }
        return $this->db->lastError();
    }

    /**
     * Helpers
     */
    public function currentUserId($userId = null)
    {
        if(!is_null($userId)) return $userId;
        return $this->userId();
    }

    protected function extractFillableFields(&$data) 
    {
        $data = $this->extractData($data, $this->fillable);

        return $this;
    }

    protected function extractUniqueFields(&$data) 
    {
        $data = $this->extractData($data, $this->unique);

        return $this;
    }

    protected function extractData($data, $identifier)
    {
        return array_filter($data, function($key) use($identifier) {
            return in_array($key, $identifier);
        }, ARRAY_FILTER_USE_KEY);
    }
}
