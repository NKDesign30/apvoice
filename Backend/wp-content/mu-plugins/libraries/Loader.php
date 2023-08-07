<?php

namespace awsm\wp\libraries;

class Loader {

	protected $actions = array();
	protected $filters = array();
	protected $shortcodes = array();

	/**
	 * @param string $hook name of the WordPress hook
	 * @param object $obj class for callable
	 * @param string $callback the callback function
	 */
	public function add_action( $hook, $obj, $callback ) {
		$this->actions = $this->add( $this->actions, $hook, $obj, $callback );
	}


	/**
	 * @param string $hook name of the WordPress hook
	 * @param object $obj class for callable
	 * @param string $callback the callback function
	 */
	public function add_filter( $hook, $obj, $callback, $priority = 10, $accepted_args = 1) {
		$this->filters = $this->add( $this->filters, $hook, $obj, $callback, $priority, $accepted_args );
	}


	/**
	 * @param string $hook name of the WordPress hook
	 * @param object $obj class for callable
	 * @param string $callback the callback function
	 */
	public function add_shortcode( $hook, $obj, $callback ) {
		$this->shortcodes = $this->add( $this->shortcodes, $hook, $obj, $callback );
	}

	/**
	 * @param array $hooks 
	 * @param string $hook name of the WordPress hook
	 * @param object $obj class for callable
	 * @param string $callback the callback function
	 */
	private function add( $hooks, $hook, $obj, $callback, $priority = 10, $accepted_args = 1 ) 
	{
		$hooks[] = array(
			'hook'      => $hook,
			'obj' => $obj,
			'callback'  => $callback,
			'priority' => $priority,
			'accepted_args' => $accepted_args,
		);

		return $hooks;
	}

	/**
	 * initialized all action hooks and filters
	 */
	public function run() 
	{
		foreach ($this->actions as $hook) {
			add_action( $hook['hook'], array( $hook['obj'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ($this->filters as $hook) {
			add_filter( $hook['hook'], array( $hook['obj'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ($this->shortcodes as $hook) {
			add_shortcode( $hook['hook'], array( $hook['obj'], $hook['callback'] ) );
		}
	}

}