<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ReportBundle\Configuration;

use DateInterval;
use DatePeriod;
use DateTime;

/**
 * Class ReportConfiguration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReportConfiguration
{
    /**
     * @var DateTime
     */
    protected $startDate;

    /**
     * @var DateTime
     */
    protected $endDate;

    /**
     * @var DateInterval
     */
    protected $interval;

    /**
     * @var string
     */
    protected $groupByDateFormat;

    /**
     * @var string
     */
    protected $datePresentationFormat;

    /**
     * @param DateTime     $startDate
     * @param DateTime     $endDate
     * @param DateInterval $interval
     * @param string       $groupByDateFormat
     * @param string       $datePresentationFormat
     */
    public function __construct(
        DateTime $startDate,
        DateTime $endDate,
        DateInterval $interval,
        $groupByDateFormat,
        $datePresentationFormat
    ) {
        $this->startDate              = $startDate;
        $this->endDate                = $endDate;
        $this->interval               = $interval;
        $this->groupByDateFormat      = $groupByDateFormat;
        $this->datePresentationFormat = $datePresentationFormat;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return DateInterval
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @return string
     */
    public function getGroupByDateFormat()
    {
        return $this->groupByDateFormat;
    }

    /**
     * @return string
     */
    public function getDatePresentationFormat()
    {
        return $this->datePresentationFormat;
    }

    /**
     * @return \DatePeriod|\DateTime[]
     */
    public function getPeriods()
    {
        return new DatePeriod($this->getStartDate(), $this->getInterval(), $this->getEndDate());
    }
}
