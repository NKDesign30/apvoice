<?php
/*
Plugin Name: Autoloader
Plugin URI: https://www.awsm.rocks
Description: Load classes by namespace
Version: 1.0.0
Author: Mark Sitko
Author URI:  https://www.awsm.rocks
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: awsm_al
 */

namespace awsm\wp\loader;

/**
 * Class loader
 */
class ClassLoader
{
    /**
     * @var array
     */
    private $namespaces = null;

    /**
     * @var ClassLoader
     */
    private static $instance = null;


    /**
     * Initialize autoload
     */
    public static function init()
    {
        if (self::$instance) {
            return;
        }

        self::$instance = new self(self::getDefaultNamespaces());

        spl_autoload_register(self::$instance);
    }

    /**
     * @return array
     */
    public static function getDefaultNamespaces()
    {
        return  array(
            'awsm\\wp\\libraries\\' => array('libraries'),
        );
    }

    /**
     * @return self
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self(self::getDefaultNamespaces());
        }

        return self::$instance;
    }

    /**
     * Construct
     *
     * @param array $namespaces
     */
    public function __construct(array $namespaces)
    {
        $this->addNamespaces($namespaces);
    }

    /**
     * @param string $class
     * @return boolean|string
     */
    protected function findFile($class)
    {
        $first = substr($class, 0, 1);

        if (!isset($this->namespaces[$first])) {
            return false;
        }

        foreach ($this->namespaces[$first] as $prefix => $paths) {
            if (strpos($class, $prefix) === 0) {
                $file = substr($class, strlen($prefix));
                $file = str_replace('\\', DIRECTORY_SEPARATOR, $file) . '.php';

                foreach ($paths as $path) {
                    if (file_exists($path. DIRECTORY_SEPARATOR . $file)) {
                        return $path. DIRECTORY_SEPARATOR . $file;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param string $class
     */
    public function __invoke($class)
    {
        if ($file = $this->findFile($class)) {
            include $file;
            return true;
        }
    }

    /**
     * @return self
     */
    public function addNamespaces(array $namespaces)
    {
        foreach ($namespaces as $ns => $paths) {
            $this->add($ns, $paths);
        }

        return $this;
    }

    /**
     * @param string $prefix
     * @param string $paths
     */
    public function add($prefix, $paths)
    {
        $first = substr($prefix, 0, 1);
        if ($first != strtolower($first)) {
            return;
        }

        if (!is_array($paths)) {
            $paths = array($paths);
        }

        foreach ($paths as $path) {
            if (substr($prefix, -1) != '\\') {
                $prefix .= '\\';
            }

            $this->namespaces[$first][$prefix][] = $path;
        }
    }
}

ClassLoader::init();
