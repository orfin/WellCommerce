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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use ZendSearch\Lucene\Analysis\Analyzer\Analyzer;
use ZendSearch\Lucene\Analysis\Analyzer\Common\Utf8\CaseInsensitive;
use ZendSearch\Lucene\Lucene;
use ZendSearch\Lucene\Search\QueryParser;
use ZendSearch\Lucene\Storage\Directory\Filesystem as LuceneFilesystem;

/**
 * Class LuceneSearchIndexManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LuceneSearchIndexManager implements SearchIndexManagerInterface
{
    /**
     * @var array
     */
    protected $options = [];

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
    public function __construct(KernelInterface $kernel, array $options = [])
    {
        $this->kernel = $kernel;
        $resolver     = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'max_buffered_docs',
            'max_merge_docs',
            'merge_factor',
        ]);

        $resolver->setDefaults([
            'max_buffered_docs' => 10,
            'max_merge_docs'    => 100000,
            'merge_factor'      => 10,
        ]);

        $resolver->setAllowedTypes('max_buffered_docs', 'int');
        $resolver->setAllowedTypes('max_merge_docs', 'int');
        $resolver->setAllowedTypes('merge_factor', 'int');
    }

    /**
     * {@inheritdoc}
     */
    public function createIndex($name)
    {
        $path  = $this->getIndexPath($name);
        $index = Lucene::create($path);

        return $index;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndex($name)
    {
        $path = $this->getIndexPath($name);

        if (!$this->checkPath($path)) {
            $index = Lucene::create($path);
        } else {
            $index = Lucene::open($path);
        }

        Analyzer::setDefault(new CaseInsensitive);
        LuceneFilesystem::setDefaultFilePermissions(0775);
        QueryParser::setDefaultEncoding('UTF-8');

        $index->setMaxBufferedDocs($this->options['max_buffered_docs']);
        $index->setMaxMergeDocs($this->options['max_merge_docs']);
        $index->setMergeFactor($this->options['merge_factor']);

        $index->optimize();

        return $index;
    }

    /**
     * {@inheritdoc}
     */
    public function hasIndex($name)
    {
        $path = $this->getIndexPath($name);

        return $this->checkPath($path);
    }

    /**
     * {@inheritdoc}
     */
    public function removeIndex($name)
    {
        $path       = $this->getIndexPath($name);
        $filesystem = new Filesystem();
        if ($filesystem->exists($path)) {
            $filesystem->remove($path);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function eraseIndex($name)
    {
        $path       = $this->getIndexPath($name);
        $filesystem = new Filesystem();
        if ($filesystem->exists($path)) {
            $filesystem->remove($path);
        }

        $this->createIndex($name);
    }

    /**
     * Returns the path for given index
     *
     * @param string $name
     *
     * @return string
     */
    private function getIndexPath($name)
    {
        $kernelDir = $this->kernel->getRootDir();

        return $kernelDir . '/store/lucene/' . Helper::snake($name);
    }

    private function checkPath($path)
    {
        return file_exists($path) && is_readable($path) && ($resources = scandir($path)) && (count($resources) > 2);
    }
}
