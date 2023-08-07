<?php 

namespace apo\reporting\utilities;

trait DateRangeTrait 
{

    public function createDateRange($startDate, $endDate) {
        $start = new \DateTime( $startDate );
        $end = new \DateTime( $endDate );
        $end = $end->modify( '+1 day' );

        $interval = new \DateInterval('P1D');
        return new \DatePeriod($start, $interval ,$end);
    }

}