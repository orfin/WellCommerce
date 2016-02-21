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

namespace WellCommerce\Bundle\ApiBundle\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\SerializerInterface;
use WellCommerce\Bundle\ApiBundle\Exception\ResourceNotFoundException;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Component\DataSet\Conditions\ConditionsResolver;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class RequestHandler
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var string
     */
    protected $resourceType;

    /**
     * RequestHandler constructor.
     *
     * @param                     $resourceType
     * @param DataSetInterface    $dataset
     * @param ManagerInterface    $manager
     * @param SerializerInterface $serializer
     * @param array               $options
     */
    public function __construct(
        $resourceType,
        DataSetInterface $dataset,
        ManagerInterface $manager,
        SerializerInterface $serializer,
        array $options = []
    ) {
        $this->resourceType = $resourceType;
        $this->dataset      = $dataset;
        $this->manager      = $manager;
        $this->serializer   = $serializer;
        $resolver           = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'page',
            'limit',
            'order_by',
            'order_dir',
        ]);

        $resolver->setDefaults([
            'page'      => 1,
            'limit'     => 100,
            'order_by'  => 'id',
            'order_dir' => 'asc',
        ]);

        $resolver->setAllowedTypes('page', 'numeric');
        $resolver->setAllowedTypes('limit', 'numeric');
        $resolver->setAllowedTypes('order_by', 'string');
        $resolver->setAllowedTypes('order_dir', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function handleListRequest(Request $request)
    {
        $conditions         = new ConditionsCollection();
        $conditionsResolver = new ConditionsResolver();
        $conditionsResolver->resolveConditions($request->request->get('where'), $conditions);

        $result = $this->dataset->getResult('array', [
            'limit'      => $request->request->get('limit', $this->options['limit']),
            'page'       => $request->request->get('page', $this->options['page']),
            'order_by'   => $request->request->get('order_by', $this->options['order_by']),
            'order_dir'  => $request->request->get('order_dir', $this->options['order_dir']),
            'conditions' => $conditions
        ]);

        $data = $this->serializer->serialize($result, self::RESPONSE_FORMAT);

        return new Response($data);
    }

    /**
     * {@inheritdoc}
     */
    public function handleCreateRequest(Request $request)
    {
        $result = $this->manager->initResource();
        $data   = $this->serializer->serialize($result, self::RESPONSE_FORMAT, ['group' => $this->getResourceType()]);

        return new Response($data);
    }

    /**
     * {@inheritdoc}
     */
    public function handleDeleteRequest(Request $request, $identifier)
    {
        $resource = $this->manager->getRepository()->find($identifier);
        if (null === $resource) {
            throw new ResourceNotFoundException($this->getResourceType(), $identifier);
        }

        $this->manager->removeResource($resource);

        return new JsonResponse([
            'success'       => true,
            'identifier'    => $identifier,
            'resource_type' => $this->getResourceType()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function handleUpdateRequest(Request $request, $identifier)
    {
        // TODO: Implement handleUpdateRequest() method.
    }

    /**
     * {@inheritdoc}
     */
    public function handleGetRequest(Request $request, $identifier)
    {
        $result = $this->manager->getRepository()->find($identifier);
        if (null === $result) {
            throw new ResourceNotFoundException($this->getResourceType(), $identifier);
        }

        $data = $this->serializer->serialize($result, self::RESPONSE_FORMAT, ['group' => $this->getResourceType()]);

        return new Response($data);
    }
}
