<?php 

namespace apo\migration\controllers\migration;

use apo\expertpoints\models\ExpertPoint;
use apo\migration\controllers\AbstractMigrationController;

class ExpertPointsMigrationController extends AbstractMigrationController
{

    /**
     * Define files and directories
     */
    const FILE_PREFIX = null;
    const DIRECTORY = null;

    /**
     * The user id for the given user
     */
    protected $userId;

    /**
     * Points from old platform
     */
    protected $points;

    /**
     * The Expert Point Model
     */
    protected $expertPoint;

    /**
     * @param int|string $newUserId The new created user id
     * @param int|string $points The current points from migrated user
     * @return this ExpertPointsMigrationController
    * Creates a new instance of ExpertPointsMigrationController
    */
    public function __construct($userId, $points = 0)
    {
        $this->userId = $userId;
        $this->points = $points;

        $this->expertPoint = new ExpertPoint();
        parent::__construct();

        return $this;
    }

    /**
     * Create a new expert point record
     * @return mixed ExpertPoint
     */
    public function create()
    {
         return $this->expertPoint->createOrUpdate([
             'user_id' => $this->userId,
             'points_earned' => $this->points,
             'related_type' => 'migration',
             'related_id' => -1
         ]);
    }

    public function remove()
    {
        return $this->expertPoint->db->delete($this->expertPoint->table, ['user_id' => $this->userId]);
    }
}