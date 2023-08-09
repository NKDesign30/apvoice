<?php

namespace apo\reporting\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use apo\reporting\models\DailyStats;
use apo\reporting\models\DailyStatsPerSalesRep;
use apo\reporting\models\DailyStatsPerTrainingsCategory;
use apo\reporting\models\DailyStatsPerTrainingsCategoryPerUserRole;
use apo\reporting\models\DailyStatsPerUserRole;
use apo\reporting\models\DailyStatsTotalHCPs;
use apo\reporting\models\DailyStatsNewRegisteredHCPs;
use apo\reporting\models\DailyStatsTraningsHCPsCompletionRate;
use apo\reporting\models\DailyStatsPerJobRole;
use apo\reporting\models\DailyStatsPerTraining;
use apo\reporting\models\DailyStatsPerSurvey;
use apo\reporting\models\DailyStatsPerActivation;
use apo\reporting\models\DailyStatsPerDownload;
use apo\reporting\utilities\PruneUserRolesTrait;
use apo\reporting\utilities\JobRolesTrait;

class ReportingController extends Controller
{

    use PruneUserRolesTrait, JobRolesTrait;

    /**
     * Incoming request
     */
    protected $request;

    /**
     * Extracted auth header from incoming request
     */
    protected $authHeader;

    /**
     * Start date  for reporting
     * @param date Y-m-d
     */
    protected $startDate;

    /**
     * End date for reporting
     * @param date-string Y-m-d
     */
    protected $endDate;

    /**
     * Reporting relevant user roles
     */
    protected $roles;

    /**
     * Encoded credentials 
     */
    private $credentials;

    public function __construct()
	{
        parent::__construct();

        $this->pruneUnnecessaryRoles();
        $this->pruneUnnecessaryJobRoles();
    }
    
    /**
     * Returns statistics for the reporting
     * 
     * @param \WP_REST_Request $request
     * @return array 
     */
    public function index(  Request $request )
    {
        $this->handleRequest($request);

        if ( !$this->verifyCredentials() ) {
            return new \WP_Error( 
                "unauthorized_requeset", 
                "Invalid credentials", 
                array( "status" => 401 ) 
            );
        }

        return [
            'data' => [
                'totals' => [
                    'general' => $this->evaluateBasicKpi(new DailyStats),
                    'general_per_user_role' => $this->evaluateUserRoleKpi(new DailyStatsPerUserRole),
                    'general_per_job_role' => $this->evaluateJobRoleKpi(new DailyStatsPerJobRole),
                    'per_trainings_category' => $this->evaluateBasicKpi(new DailyStatsPerTrainingsCategory),
                    //'per_trainings_category_per_user_role' => $this->evaluateUserRoleKpi(new DailyStatsPerTrainingsCategoryPerUserRole),
                    'per_activation' => $this->evaluateBasicKpi(new DailyStatsPerActivation),
                    'per_training' => $this->evaluateBasicKpi(new DailyStatsPerTraining),
                    'per_survey' => $this->evaluateBasicKpi(new DailyStatsPerSurvey),
                    'per_download_product' => $this->evaluateBasicKpi(new DailyStatsPerDownload),
                ],
                'period' => [
                    'general' => $this->evaluateBasicKpiForPeriod(new DailyStats),
                    'general_per_user_role' => $this->evaluateUserRoleKpiForPeriod(new DailyStatsPerUserRole),
                    'general_per_job_role' => $this->evaluateJobRoleKpiForPeriod(new DailyStatsPerJobRole),
                    'per_trainings_category' => $this->evaluateBasicKpiForPeriod(new DailyStatsPerTrainingsCategory),
                    'per_activation' => $this->evaluateBasicKpiForPeriod(new DailyStatsPerActivation),
                    'per_training' => $this->evaluateBasicKpiForPeriod(new DailyStatsPerTraining),
                    'per_survey' => $this->evaluateBasicKpiForPeriod(new DailyStatsPerSurvey),
                    'per_download_product' => $this->evaluateBasicKpiForPeriod(new DailyStatsPerDownload),
                ],
            ],
            'meta' => [
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]
        ];
    }

    /**
     * Returns statistics for the reporting
     *
     * @param \WP_REST_Request $request
     * @return array
     */
    public function totalHCPs(  Request $request )
    {
        $this->handleRequest($request);

        if ( !$this->verifyCredentials() ) {
            return new \WP_Error(
                "unauthorized_requeset",
                "Invalid credentials",
                array( "status" => 401 )
            );
        }

        return [
            'data' => [
                'totals' => [
                    'general_per_user_role' => $this->evaluateTotalHCPs_Kpi(new DailyStatsTotalHCPs),
                ],
            ],
            'meta' => [
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]
        ];
    }

    /**
     * Returns statistics for the reporting
     *
     * @param \WP_REST_Request $request
     * @return array
     */
    public function newRegisteredHCPs(  Request $request )
    {
        $this->handleRequest($request);

        if ( !$this->verifyCredentials() ) {
            return new \WP_Error(
                "unauthorized_requeset",
                "Invalid credentials",
                array( "status" => 401 )
            );
        }

        return [
            'data' => [
                'period' => [
                    'general_per_user_role' => $this->evaluateNewRegisteredHCPsForPeriod_Kpi(new DailyStatsNewRegisteredHCPs),
                ],
            ],
            'meta' => [
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]
        ];
    }

    /**
     * Returns statistics for the reporting
     *
     * @param \WP_REST_Request $request
     * @return array
     */
    public function NewRegisteredHCPsTimeline(  Request $request )
    {
        $this->handleRequest($request);

        if ( !$this->verifyCredentials() ) {
            return new \WP_Error(
                "unauthorized_requeset",
                "Invalid credentials",
                array( "status" => 401 )
            );
        }

        return [
            'data' => [
                'period' => [
                    'general_per_user_role' => $this->evaluateNewRegisteredHCPsTimelineForPeriod_Kpi(new DailyStatsNewRegisteredHCPs),
                ],
            ],
            'meta' => [
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]
        ];
    }

    /**
     * Returns statistics for the reporting
     *
     * @param \WP_REST_Request $request
     * @return array
     */
    public function traningsHCPsCompletionRate(  Request $request )
    {
        $this->handleRequest($request);

        if ( !$this->verifyCredentials() ) {
            return new \WP_Error(
                "unauthorized_requeset",
                "Invalid credentials",
                array( "status" => 401 )
            );
        }

        return [
            'data' => [
                'totals' => [
                    'general_per_user_role' => $this->evaluateTraningsHCPsCompletionRateKpi(new DailyStatsTraningsHCPsCompletionRate),
                ],
            ],
            'meta' => [
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]
        ];
    }

    /**
     * Returns statistics for the reporting
     *
     * @param \WP_REST_Request $request
     * @return array
     */
    public function traningsInDetails(  Request $request )
    {
        $this->handleRequest($request);

        if ( !$this->verifyCredentials() ) {
            return new \WP_Error(
                "unauthorized_requeset",
                "Invalid credentials",
                array( "status" => 401 )
            );
        }

        return [
            'data' => [
                'totals' => [
                    'per_training' => $this->evaluateBasicKpi(new DailyStatsPerTraining),
                ],
            ],
            'meta' => [
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]
        ];
    }

    /**
     * @param \WP_REST_Request $request
     * @return this
     */
    protected function handleRequest($request)
    {
        $this->request = $request;

        $this->authHeader = $request->get_header('Reporting-Authorization');

        $this->extractCredentials()
            ->setDate();
        return $this;
    }

    /**
     * @return this
     */
    protected function setDate() 
    {
        $this->startDate = $this->request['start_date'] ?? date('Y-m-d', time());
        $this->endDate = $this->request['end_date'] ?? date('Y-m-d', time());
        return $this;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateUserRoleKpi($model)
    {
        $results = [];

        foreach ($this->getRoles() as $role) {
            $arr = $model->getReportingResults($this->startDate, $this->endDate, $role);
            if((is_array($arr) || is_object($arr)) && count($arr) > 0)
                $results[] = $arr;
        }

        return $results;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateTotalHCPs_Kpi($model)
    {
        $results = [];

        $role = 'hcp';
        $arr = $model->getReportingResults($this->startDate, $this->endDate, $role);
        if((is_array($arr) || is_object($arr)) && count($arr) > 0)
            $results[] = $arr;

        return $results;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateNewRegisteredHCPsForPeriod_Kpi($model)
    {
        $results = [];

        $role = 'hcp';
        foreach ($this->getPeriod() as $key => $value) {
            $arr = $model->getReportingResults($value->format('Y-m-d'), $value->format('Y-m-d'), $role);
            if((is_array($arr) || is_object($arr)) && count($arr) > 0)
                $results[] = $arr;
        }

        return $results;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateNewRegisteredHCPsTimelineForPeriod_Kpi($model)
    {
        $results = [];

        $role = 'hcp';
        foreach ($this->getPeriod() as $key => $value) {
            $arr = $this->addDate($model->getReportingResults($value->format('Y-m-d'), $value->format('Y-m-d'), $role), $value->format('Y-m-d'));
            if((is_array($arr) || is_object($arr)) && count($arr) > 0)
                $results[] = $arr;
        }

        return $results;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateTraningsHCPsCompletionRateKpi($model)
    {
        $results = [];

        $role = 'hcp';
        $arr = $model->getReportingResults($this->startDate, $this->endDate, $role);
        if((is_array($arr) || is_object($arr)) && count($arr) > 0)
            $results[] = $arr;

        return $results;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateJobRoleKpi($model)
    {
        $results = [];

        foreach ($this->getJobRoles() as $role) {
            $arr = $model->getReportingResults($this->startDate, $this->endDate, $role['value']);
            if((is_array($arr) || is_object($arr)) && count($arr) > 0)
                $results[] = $arr;
        }

        return $results;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return object
     */
    protected function evaluateBasicKpi($model)
    {
        return $model->getReportingResults($this->startDate, $this->endDate);
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateUserRoleKpiForPeriod($model)
    {
        $results = [];

        foreach ($this->getRoles() as $role) {
            foreach ($this->getPeriod() as $key => $value) {
                $arr = $this->addDate($model->getReportingResults($value->format('Y-m-d'), $value->format('Y-m-d'), $role), $value->format('Y-m-d'));
                if((is_array($arr) || is_object($arr)) && count($arr) > 0)
                    $results[] = $arr;
            }
        }

        return $results;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateJobRoleKpiForPeriod($model)
    {
        $results = [];

        foreach ($this->getJobRoles() as $role) {
            foreach ($this->getPeriod() as $key => $value) {
                $arr = $this->addDate($model->getReportingResults($value->format('Y-m-d'), $value->format('Y-m-d'), $role['value']), $value->format('Y-m-d'));
                if((is_array($arr) || is_object($arr)) && count($arr) > 0)
                    $results[] = $arr;
            }
        }

        return $results;
    }

    /**
     * @param  awsm\wp\libraries\Model $model
     * @return array $results
     */
    protected function evaluateBasicKpiForPeriod($model)
    {
        $results = [];
        foreach ($this->getPeriod() as $key => $value) {
            $results[] = $this->addDate($model->getReportingResults($value->format('Y-m-d'), $value->format('Y-m-d')), $value->format('Y-m-d'));
        }

        return $results;
    }

    /**
     * @param  object $results
     * @param  date Y-m-d $date
     * @return object $results
     */
    protected function addDate($results, $date)
    {
        $results->date = $date;
        return $results;
    }

    /**
     * Extract and decode the credentials from auth header
     * @return this
     */
    private function extractCredentials() 
    {
        preg_match('/Basic\s(.*)/', $this->authHeader, $matches);

        [$header, $credentials] = $matches;

        $this->credentials = base64_decode( trim($credentials) );

        return $this;
    }

    /**
     * @return boolean
     */
    private function verifyCredentials()
    {
        return $this->credentials === REPORTING_API_SECRET;
    }

    /**
     * Creates a date period with the start and end date
     * @return \DatePeriod
     */
    private function getPeriod()
    {
        return new \DatePeriod(
            new \DateTime($this->startDate),
            new \DateInterval('P1D'),
            new \DateTime($this->endDate)
       );   
    }

} 
