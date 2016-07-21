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

namespace WellCommerce\Bundle\LocaleBundle\Command;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;
use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;

/**
 * Class DeleteLocaleCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DeleteLocaleCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Deletes a locale and related translatable entities');
        $this->setName('wellcommerce:locale:delete');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceLocales = $this->getSourceLocales();
        if (1 === count($sourceLocales)) {
            $output->write('<error>Cannot delete any locale. Only one exists.</error>', true);
            
            return false;
        }
        
        $helper        = $this->getHelper('question');
        $question      = new ChoiceQuestion('Please select a locale which will be deleted:', $sourceLocales);
        $choosenLocale = $helper->ask($input, $output, $question);
        
        $this->deleteLocaleData($choosenLocale, $output);
        
        $this->getDoctrineHelper()->getEntityManager()->flush();
        
        $output->writeln(sprintf('<info>Deleted the locale "%s"</info>', $choosenLocale));
        
        return true;
    }
    
    /**
     * Deletes the locale
     *
     * @param                 $localeCode
     * @param OutputInterface $output
     */
    protected function deleteLocaleData($localeCode, OutputInterface $output)
    {
        $entityManager = $this->getDoctrineHelper()->getEntityManager();
        $metadata      = $this->getDoctrineHelper()->getAllMetadata();
        $locale        = $this->getLocaleRepository()->findOneBy(['code' => $localeCode]);
        if (!$locale instanceof LocaleInterface) {
            throw new InvalidArgumentException(sprintf('Wrong locale code "%s" was given', $localeCode));
        }
        foreach ($metadata as $classMetadata) {
            $reflectionClass = $classMetadata->getReflectionClass();
            if ($reflectionClass->implementsInterface(\WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface::class)) {
                $repository = $entityManager->getRepository($reflectionClass->getName());
                $this->deleteTranslatableEntities($repository, $locale, $output);
            }
        }
        
        $entityManager->remove($locale);
    }
    
    /**
     * Deletes the translatable entities for locale
     *
     * @param EntityRepository $repository
     * @param LocaleInterface  $locale
     * @param OutputInterface  $output
     */
    protected function deleteTranslatableEntities(EntityRepository $repository, LocaleInterface $locale, OutputInterface $output)
    {
        $entityManager = $this->getDoctrineHelper()->getEntityManager();
        $criteria      = new Criteria();
        $criteria->where($criteria->expr()->eq('locale', $locale->getCode()));
        $collection = $repository->matching($criteria);
        
        $collection->map(function (LocaleAwareInterface $entity) use ($entityManager) {
            $entityManager->remove($entity);
        });
        
        $output->write(sprintf(
            'Deleted <info>%s</info> entities <info>%s</info>',
            $collection->count(),
            $repository->getClassName()
        ), true);
    }
    
    
    /**
     * @return array
     */
    protected function getSourceLocales()
    {
        $locales    = [];
        $collection = $this->getLocaleRepository()->matching(new Criteria());
        
        $collection->map(function (LocaleInterface $locale) use (&$locales) {
            $locales[$locale->getCode()] = $locale->getCode();
        });
        
        return $locales;
    }
    
    private function getDoctrineHelper() : DoctrineHelperInterface
    {
        return $this->getContainer()->get('doctrine.helper');
    }
    
    private function getLocaleRepository() : LocaleRepositoryInterface
    {
        return $this->getContainer()->get('locale.repository');
    }
}
