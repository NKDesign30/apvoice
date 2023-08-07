<?php

namespace awsm\wp\libraries;

class DB 
{

	public $wpdb;
	public $defaultPrefix;
	private $connection;
	private static $instance;

	/**
	 * @return self
	 */
	public static function instance()
	{
		if (!self::$instance && !self::$instance instanceof DB) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	private function __construct() 
	{
		global $wpdb;
		$this->connect($wpdb);
		$this->wpdb = $wpdb;
		$this->setDefaultDBPrefix();
	}

	public function select($query, $output = 'OBJECT') 
	{
		return $this->connection->get_results($query, $output);
	}

	public function selectRow($query, $output = 'OBJECT')
	{
		return $this->connection->get_row($query, $output);
	}

	public function prepare($query, ...$args) 
	{
		return $this->connection->prepare($query, $args);
	}

	public function lastid()
	{
		return $this->connection->insert_id;
	}

	public function lastError()
	{
		return $this->connection->last_error;
	}

	public function insert($table, $data, $format = null)
	{
		if (!is_null($format)) {
			return $this->connection->insert($table, $data, $format);
		} else {
			return $this->connection->insert($table, $data);
		}
	}

	public function update($table, $data, $where)
	{
		return $this->connection->update($table, $data, $where);
	}

	public function delete($table, $where)
	{
		return $this->connection->delete($table, $where);
	}

	public function countRows($table, $where = null)
	{
		$query = "SELECT COUNT(*) FROM " . $table;
		if (!is_null($where)) {
			$query .= " WHERE " . $where;
		}
		return $this->connection->get_var($query);
	}

	public function count($query)
	{
		return $this->connection->get_var($query);
	}

	/**
	 * Useful for creating new tables and updating existing tables to a new structure.
	 * 
	 * @param string|string[] $queries
	 * The query to run. Can be multiple queries in an array, or a string of queries separated by semicolons.
	 * 
	 * @param boolean $execute
	 * Whether or not to execute the query right away.
	 * 
	 * @return Array
	 */
	public function createTable($queries, $execute = true)
	{
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		return dbDelta( $queries, $execute );
	}

	public function setDefaultDBPrefix() 
	{
		switch_to_blog( 1 );
		$this->defaultPrefix = $this->wpdb->prefix;
		restore_current_blog();

		return $this;
	}

	private function connect($connection)
	{
		$this->connection = $connection;
	}

}