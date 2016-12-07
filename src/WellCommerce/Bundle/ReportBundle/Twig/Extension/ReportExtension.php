<?php
/**
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ReportBundle\Twig\Extension;

use Carbon\Carbon;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\ReportBundle\Provider\SalesReportProvider;

/**
 * Class ReportExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ReportExtension extends \Twig_Extension
{
    /**
     * @var string Template name
     */
    private $templateName;
    
    /**
     * @var \Twig_Environment
     */
    private $environment;
    
    /**
     * @var SalesReportProvider
     */
    private $salesReportProvider;
    
    /**
     * @var RequestHelperInterface
     */
    private $requestHelper;
    
    /**
     * ReportExtension constructor.
     *
     * @param string                 $templateName
     * @param SalesReportProvider    $salesReportProvider
     * @param RequestHelperInterface $requestHelper
     */
    public function __construct(string $templateName, SalesReportProvider $salesReportProvider, RequestHelperInterface $requestHelper)
    {
        $this->templateName        = $templateName;
        $this->salesReportProvider = $salesReportProvider;
        $this->requestHelper       = $requestHelper;
    }
    
    /**
     * Initializes Twig
     *
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }
    
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('sales_report', [$this, 'renderSalesReport'], ['is_safe' => ['html', 'javascript']]),
        ];
    }
    
    
    public function renderSalesReport(string $redirectRouteName): string
    {
        $start     = $this->requestHelper->getCurrentRequest()->get('startDate') ?? null;
        $end       = $this->requestHelper->getCurrentRequest()->get('endDate') ?? null;
        $startDate = (null === $start) ? Carbon::now()->startOfMonth() : Carbon::createFromTimestamp(strtotime($start))->startOfDay();
        $endDate   = (null === $end) ? Carbon::now()->endOfMonth() : Carbon::createFromTimestamp(strtotime($end))->endOfDay();
        $summary   = $this->salesReportProvider->getSummary($startDate, $endDate);
        $chartData = $this->salesReportProvider->getChartData($startDate, $endDate);
        
        return $this->environment->render($this->templateName, [
            'salesChart'        => $chartData,
            'salesSummary'      => $summary->getSummary(),
            'currency'          => $this->requestHelper->getCurrentCurrency(),
            'startDate'         => $startDate->format('Y-m-d'),
            'endDate'           => $endDate->format('Y-m-d'),
            'redirectRouteName' => $redirectRouteName,
        ]);
    }
    
    public function getName()
    {
        return 'report';
    }
}