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

namespace WellCommerce\Bundle\SearchBundle\Manager;

use Ivory\LuceneSearchBundle\Model\LuceneManager;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;

/**
 * Class LuceneSearchIndexManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LuceneSearchIndexManager implements SearchIndexManagerInterface
{
    /**
     * @var LuceneManager
     */
    protected $luceneManager;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * LuceneSearchManager constructor.
     *
     * @param LuceneManager   $luceneManager
     * @param KernelInterface $kernel
     */
    public function __construct(LuceneManager $luceneManager, KernelInterface $kernel)
    {
        $this->luceneManager = $luceneManager;
        $this->kernel        = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function createIndex($name)
    {
        $kernelDir = $this->kernel->getRootDir();
        $indexDir  = $kernelDir . '/store/lucene/' . Helper::snake($name);

        $this->luceneManager->setIndex(
            $name,
            $indexDir,
            'ZendSearch\Lucene\Analysis\Analyzer\Common\Utf8\CaseInsensitive'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getIndex($name)
    {
        if (!$this->luceneManager->hasIndex($name)) {
            $this->createIndex($name);
        }

        return $this->luceneManager->getIndex($name);
    }

    /**
     * {@inheritdoc}
     */
    public function removeIndex($name)
    {
        $index = $this->getIndex($name);
        if ($index->count()) {
            $this->luceneManager->removeIndex($name, false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function eraseIndex($name)
    {
        $index = $this->getIndex($name);
        if ($index->count()) {
            $this->luceneManager->eraseIndex($name);
        }
    }
}
