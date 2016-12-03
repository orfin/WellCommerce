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
use WellCommerce\Bundle\AdminBundle\Entity\AdminMenu;
use WellCommerce\Bundle\AdminBundle\Repository\AdminMenuRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;

/**
 * Class XmlImporter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class XmlImporter implements AdminMenuImporterInterface
{
    /**
     * @var DoctrineHelperInterface
     */
    private $doctrineHelper;
    
    /**
     * @var AdminMenuRepositoryInterface
     */
    private $adminMenuRepository;
    
    /**
     * Constructor
     *
     * @param DoctrineHelperInterface      $doctrineHelper
     * @param AdminMenuRepositoryInterface $adminMenuRepository
     */
    public function __construct(DoctrineHelperInterface $doctrineHelper, AdminMenuRepositoryInterface $adminMenuRepository)
    {
        $this->doctrineHelper      = $doctrineHelper;
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
        $adminMenuItem = $this->adminMenuRepository->findOneBy(['identifier' => (string)$item->identifier]);
        $parent        = $this->adminMenuRepository->findOneBy(['identifier' => (string)$item->parent]);
        
        if (null === $adminMenuItem) {
            $adminMenuItem = new AdminMenu();
            $adminMenuItem->setCssClass((string)$item->css_class);
            $adminMenuItem->setIdentifier((string)$item->identifier);
            $adminMenuItem->setName((string)$item->name);
            $adminMenuItem->setRouteName((string)$item->route_name);
            $adminMenuItem->setHierarchy((int)$item->hierarchy);
            $adminMenuItem->setParent($parent);
            
            $em->persist($adminMenuItem);
            $em->flush();
        }
    }
    
    private function parseFile(string $file): \DOMDocument
    {
        return XmlUtils::loadFile($file);
    }
}
