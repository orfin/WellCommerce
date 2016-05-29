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

namespace WellCommerce\Component\Search\Event;

use Symfony\Component\EventDispatcher\Event;
use WellCommerce\Component\Search\Model\SearchRequestInterface;

/**
 * Class SearchEvent
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchEvent extends Event
{
    const SEARCH_REQUEST_START_EVENT_NAME  = 'search_request.start';
    const SEARCH_REQUEST_FINISH_EVENT_NAME = 'search_request.finish';
    
    /**
     * @var SearchRequestInterface
     */
    private $request;

    /**
     * @var array
     */
    private $results;

    /**
     * SearchEvent constructor.
     *
     * @param SearchRequestInterface $request
     * @param array                  $results
     */
    public function __construct(SearchRequestInterface $request, array $results)
    {
        $this->request = $request;
        $this->results = $results;
    }

    public function getRequest() : SearchRequestInterface
    {
        return $this->request;
    }

    public function getResults() : array
    {
        return $this->results;
    }
}
