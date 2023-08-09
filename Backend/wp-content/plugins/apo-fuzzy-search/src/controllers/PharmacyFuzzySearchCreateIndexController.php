<?php

namespace apo\fuzzysearch\controllers;

use apo\fuzzysearch\support\search\CreatePharmaciesCSV;
use apo\fuzzysearch\support\search\CreateSearchIndex;
use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;

class PharmacyFuzzySearchCreateIndexController extends Controller
{
	public function __construct() 
	{
        parent::__construct();
	}

    public function __invoke(  Request $request )
    {
        return [
            'csv_index' => CreatePharmaciesCSV::create(),
            'search_index' => CreateSearchIndex::create(),
        ];
    }
} 
