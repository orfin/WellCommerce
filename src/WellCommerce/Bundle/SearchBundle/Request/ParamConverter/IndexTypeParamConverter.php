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

namespace WellCommerce\Bundle\SearchBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\SearchBundle\Manager\SearchManagerInterface;
use WellCommerce\Bundle\SearchBundle\Type\IndexType;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class IndexTypeParamConverter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class IndexTypeParamConverter implements ParamConverterInterface
{
    /**
     * @var SearchManagerInterface
     */
    private $manager;

    /**
     * IndexTypeParamConverter constructor.
     *
     * @param SearchManagerInterface $manager
     */
    public function __construct(SearchManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $indexType = $this->manager->getIndexType($request->get('indexType'));
        $request->attributes->set($configuration->getName(), $indexType);

        return true;
    }
    
    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }
        
        $supportedTypes = [
            IndexTypeInterface::class,
            IndexType::class
        ];
        
        return in_array($configuration->getClass(), $supportedTypes);
    }
}
