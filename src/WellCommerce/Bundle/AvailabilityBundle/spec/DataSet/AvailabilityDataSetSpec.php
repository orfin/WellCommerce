<?php

namespace spec\WellCommerce\Bundle\AvailabilityBundle\DataSet;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetOptionsResolver;
use WellCommerce\Bundle\CoreBundle\DataSet\QueryBuilder\QueryBuilderInterface;

/**
 * Class AvailabilityDataSetSpec
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 * @mixin \WellCommerce\Bundle\AvailabilityBundle\DataSet\AvailabilityDataSet;
 */
class AvailabilityDataSetSpec extends ObjectBehavior
{
    function let($identifier, QueryBuilderInterface $queryBuilder)
    {
        $this->beConstructedWith($identifier, $queryBuilder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\AvailabilityBundle\DataSet\AvailabilityDataSet');
    }

    function it_allows_to_be_configured()
    {
        $resolver = new DataSetOptionsResolver();
        $this->configureOptions($resolver);
        $this->get->shouldBeAnInstanceOf('WellCommerce\Bundle\AvailabilityBundle\DataSet\AvailabilityDataSet');
    }
}
