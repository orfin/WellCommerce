<?php

namespace spec\WellCommerce\Bundle\AvailabilityBundle\DataSet;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\DataSetBundle\DataSetConfigurator;
use WellCommerce\Bundle\DataSetBundle\Loader\DataSetLoader;

/**
 * Class AvailabilityDataSetSpec
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 * @mixin \WellCommerce\Bundle\AvailabilityBundle\DataSet\AvailabilityDataSet;
 */
class AvailabilityDataSetSpec extends ObjectBehavior
{
    function let(ContainerInterface $container, $identifier, DataSetLoader $dataSetLoader)
    {
        $container->has('event_dispatcher')->willReturn(true);
        $this->beConstructedWith($identifier, $dataSetLoader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WellCommerce\Bundle\AvailabilityBundle\DataSet\AvailabilityDataSet');
    }

    function it_allows_to_be_configured(ContainerInterface $container)
    {
        $container->has('event_dispatcher')->willReturn(true);
        $resolver        = new DataSetConfigurator($container->get('event_dispatcher'));
        $this->configureOptions($resolver);
        $this->get->shouldBeAnInstanceOf('WellCommerce\Bundle\AvailabilityBundle\DataSet\AvailabilityDataSet');
    }
}
