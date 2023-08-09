<?php

namespace apo\migration\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use apo\migration\models\MigrationStatus;
use apo\migration\utilities\MigrationDatabaseConnector;


abstract class AbstractMigrationController extends Controller
{

    public $migrationDB; 

    /**
     * The countries to be migrated
     * the country key is to locate the temp json files
     * the value is from there current database to locate the users
     */
    protected $countries = [
        'de' => 'Deutschland', 
        'at' => 'Österreich',
    ];

    /**
     * Map the country key to the future blog id
     */
    protected $countryBlogMapper = [];

     /**
     * Defines start prefix of file
     */
    protected $filePrefix;

    /**
     * Defines subdirectories
     */
    protected $directory;

    /**
     * Migration Status Model
     */
    protected $migrationStatus;

    public function __construct()
	{
        parent::__construct();

        if ( static::FILE_PREFIX ) {
            $this->filePrefix = static::FILE_PREFIX;
        }

        if ( static::DIRECTORY) {
            $this->directory = static::DIRECTORY;
        }

        require_once( ABSPATH . 'wp-admin/includes/ms.php' );

        $this->migrationDB = MigrationDatabaseConnector::instance();

        $this->migrationStatus = new MigrationStatus();

        $this->collectBlogIds();
    }

    public function fetchAndWrite()
    {
        return 'FetchAndWrite method does not exists on this resource. You have to do it manually. Called Class: ' . get_called_class();
    }

    public function create()
    {
        return 'Create method does not exists on this resource. You have to do it manually. Called Class: ' . get_called_class();
    }

    public function remove()
    {
        return 'Remove method does not exists on this resource. You have to do it manually. Called Class: ' . get_called_class();
    }

    public function upload()
    {
        return 'Upload method does not exists on this resource. You have to do it manually. Called Class: ' . get_called_class();
    }

    public static function getCountryBlogMapper()
    {
        return (new static)->countryBlogMapper;
    }

    /**
     * @param string $filename
     * @param array $data
     */
    protected function writeFile($filename, $data)
    {
        return file_put_contents( APO_MIGRATION_ASSETS . "/{$filename}.json", json_encode($data));
    }

    /**
     * @param string $dir
     * @param string $filename
     * @param array $data
     */
    protected function writeFileInSubdirectory($dir, $filename, $data)
    {
        if ( !is_dir(APO_MIGRATION_ASSETS . "/{$dir}") ) {
            mkdir( APO_MIGRATION_ASSETS . "/{$dir}" );
        }
        return file_put_contents( APO_MIGRATION_ASSETS . "/{$dir}/{$filename}.json", json_encode($data));
    }

    /**
     * @param string $filename
     */
    protected function readFile($filename)
    {
        if (file_exists( APO_MIGRATION_ASSETS . "/{$filename}.json" ) ) {
            return json_decode( file_get_contents( APO_MIGRATION_ASSETS . "/{$filename}.json" ), true);
        } else {
            return "The file " . APO_MIGRATION_ASSETS . "/{$filename}.json does not exists";
        }
    }

    /**
     * @param string $filename
     */
    protected function readFileFromSubdirectory($dir, $filename)
    {
        if (file_exists( APO_MIGRATION_ASSETS . "/{$dir}/{$filename}.json" ) ) {
            return json_decode( file_get_contents( APO_MIGRATION_ASSETS . "/{$dir}/{$filename}.json" ), true);
        } else {
            return "The file " . APO_MIGRATION_ASSETS . "/{$dir}/{$filename}.json does not exists";
        }
    }

    /**
     * Collect all blog ids with exception for the main blog
     */
    protected function collectBlogIds()
    {
        $this->countryBlogMapper = [];
        foreach (get_sites() as $site) {
            if($site->path !== '/') {
                $key = str_replace('/', '', $site->path);
                $this->countryBlogMapper[$key] = $site->blog_id;
            }
        }

        return $this;
    }

    /**
     * Checks if a blog with the given country key exists
     * @param string $key
     */
    protected function blogExists($key)
    {
        return array_key_exists( $key, $this->countryBlogMapper );
    }

    /**
     * Fetchs a post by id
     * @param int|string $id
     * @return mixed
     */
    protected function fetchPostById( $id )
    {
         return $this->migrationDB->get_row(
            "SELECT
                `mtjpt_posts`.*
            FROM
                `mtjpt_posts`
            WHERE `mtjpt_posts`.`ID` = {$id}
            "
        );
    }

    /**
     * Fetchs all related meta data for a given post
     * @param int|string $id
     * @return mixed
     */
    protected function fetchPostMetaDataById( $id )
    {
         return $this->migrationDB->get_results(
            "SELECT
               `mtjpt_postmeta`.`meta_key`,
               `mtjpt_postmeta`.`meta_value`
           FROM
               `mtjpt_postmeta`
           WHERE `mtjpt_postmeta`.`post_id` = $id
            "
        );
    }

    /**
     * Create a key value pair from meta data fetch results
     * @param array $metaData
     * @return array 
     */
    protected function combineMetaData($metaData)
    {
        $combinedMetaData = [];

        foreach ($metaData as $index => $metaObject) {
            $combinedMetaData[$metaObject->meta_key] = $metaObject->meta_value;
        }

        return $combinedMetaData;
    }

    /**
     * Fetchs and combine meta data for the given post
     * @param int|stirng $id
     * @return array
     */
    protected function getPostMetaData( $id)
    {
         return $this->combineMetaData( $this->fetchPostMetaDataById( $id ) );
    }

    /**
     * Fetchs post and combine related meta data
     * @param int|string $id
     * @return mixed
     */
    protected function getPostWithMetaData( $id )
    {
         $post = $this->fetchPostById($id);
         $post->meta = $this->getPostMetaData( $post->ID );

         return $post;
    }

    protected function printResults($results)
    {
        return implode(' ', $results);
    }

    protected function setMigrationStatus()
    {
        if( static::MIGRATION_STATUS_IDENTIFIER ) {
            $this->migrationStatus->update([static::MIGRATION_STATUS_IDENTIFIER => 1], ['id' => 1]);
        }
        return $this;
    }

    protected function revokeMigrationStatus()
    {
        if( static::MIGRATION_STATUS_IDENTIFIER ) {
            $this->migrationStatus->update([static::MIGRATION_STATUS_IDENTIFIER => 0], ['id' => 1]);
        }
        return $this;
    }

    protected function hasAlreadyMigrated()
    {
        $status = static::MIGRATION_STATUS_IDENTIFIER;
        return (bool) $this->migrationStatus->showOne(1)->$status;
    }

    protected function requiredFilesExists($sets)
    {
        $exists = true;

        foreach ($this->countryBlogMapper as $countryKey => $country) {
            
            foreach ($sets as $set) {

                if($set === 'survey_user_results/survey_user_results_') {
                    if( sizeof( glob( APO_MIGRATION_ASSETS . '/' . $set . $countryKey . '*.json' ) )  === 0) {
                        $exists = false;
                        break;
                    }
                } else {
                    if( !file_exists( APO_MIGRATION_ASSETS . '/' . $set . $countryKey . '.json') ) {
                        $exists = false;
                        break;
                    }
                }
                
            }

        }

        return $exists;
    }

    protected function generateFilesPathsWrittenByCreateMode($files)
    {
        $filePaths = [];

        foreach ($this->countryBlogMapper as $countryKey => $country) {

            foreach ($files as $file) {
                $filePaths[] = APO_MIGRATION_ASSETS . '/' . $file . $countryKey . '.json';
            }
        }

        return $filePaths;
    }
    
} 
