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

namespace WellCommerce\Bundle\AdminBundle\Importer;

use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Config\Util\XmlUtils;
use WellCommerce\Bundle\AdminBundle\Factory\AdminMenuFactory;
use WellCommerce\Bundle\AdminBundle\Repository\AdminMenuRepositoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;

/**
 * Class XmlImporter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class XmlImporter implements AdminMenuImporterInterface
{
    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;

    /**
     * @var AdminMenuFactory
     */
    protected $adminMenuFactory;

    /**
     * @var AdminMenuRepositoryInterface
     */
    protected $adminMenuRepository;

    /**
     * Constructor
     *
     * @param DoctrineHelperInterface      $doctrineHelper
     * @param AdminMenuFactory             $adminMenuFactory
     * @param AdminMenuRepositoryInterface $adminMenuRepository
     */
    public function __construct(
        DoctrineHelperInterface $doctrineHelper,
        AdminMenuFactory $adminMenuFactory,
        AdminMenuRepositoryInterface $adminMenuRepository
    ) {
        $this->doctrineHelper      = $doctrineHelper;
        $this->adminMenuFactory    = $adminMenuFactory;
        $this->adminMenuRepository = $adminMenuRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function import($file, FileLocatorInterface $locator)
    {
        $path = $locator->locate($file, null, true);
        $path = is_array($path) ? current($path) : $path;
        $xml  = $this->parseFile($path);

        $this->importItems($xml);
    }

    /**
     * Parses DOM element and adds it as an admin menu item
     *
     * @param \DOMDocument $xml
     */
    protected function importItems(\DOMDocument $xml)
    {
        foreach ($xml->documentElement->getElementsByTagName('item') as $item) {
            $dom = simplexml_import_dom($item);
            $this->addMenuItem($dom);
        }
    }

    /**
     * Creates new admin menu item
     *
     * @param \SimpleXMLElement $item
     */
    protected function addMenuItem(\SimpleXMLElement $item)
    {
        $em            = $this->doctrineHelper->getEntityManager();
        $adminMenuItem = $this->adminMenuRepository->findOneBy(['identifier' => $item->identifier]);
        $parent        = $this->adminMenuRepository->findOneBy(['identifier' => $item->parent]);

        if (null === $adminMenuItem) {
            $adminMenuItem = $this->adminMenuFactory->create();
            $adminMenuItem->setCssClass($item->css_class);
            $adminMenuItem->setIdentifier($item->identifier);
            $adminMenuItem->setName($item->name);
            $adminMenuItem->setRouteName($item->route_name);
            $adminMenuItem->setHierarchy($item->hierarchy);
            $adminMenuItem->setParent($parent);

            $em->persist($adminMenuItem);
            $em->flush();
        }
    }

    /**
     * Parses a XML file
     *
     * @param string $file
     *
     * @return \DOMDocument
     */
    protected function parseFile($file)
    {
        return XmlUtils::loadFile($file);
    }
}
