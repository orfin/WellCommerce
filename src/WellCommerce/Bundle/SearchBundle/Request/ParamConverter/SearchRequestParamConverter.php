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

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\SearchBundle\Manager\SearchManagerInterface;
use WellCommerce\Component\Search\Model\FieldInterface;
use WellCommerce\Component\Search\Request\SearchRequest;
use WellCommerce\Component\Search\Request\SearchRequestInterface;

/**
 * Class SearchRequestParamConverter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class SearchRequestParamConverter implements ParamConverterInterface
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
        $searchRequest = $this->createSearchRequest($request);
        $request->attributes->set($configuration->getName(), $searchRequest);
        
        return true;
    }

    private function createSearchRequest(Request $request) : SearchRequestInterface
    {
        $type   = $this->manager->getType($request->get('type'));
        $phrase = $request->query->has('phrase') ? $request->query->get('phrase') : '';
        $fields = new ArrayCollection();

        $type->getFields()->map(function (FieldInterface $field) use ($fields, $request) {
            if ($request->query->has($field->getName())) {
                $field->setValue($request->query->get($field->getName(), ''));
                $fields->set($field->getName(), $field);
            }
        });

        return new SearchRequest($type, $fields, $phrase, $request->getLocale());
    }
    
    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }
        
        $supportedTypes = [
            SearchRequest::class,
            SearchRequestInterface::class,
        ];
        
        return in_array($configuration->getClass(), $supportedTypes);
    }
}
