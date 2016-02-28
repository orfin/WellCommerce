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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Intl\Intl;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\CurrencyBundle\Repository\CurrencyRepositoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;
use WellCommerce\Bundle\LocaleBundle\Factory\LocaleFactory;
use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;

/**
 * Class AddLocaleCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AddLocaleCommand extends Command
{
    /**
     * @var DoctrineHelperInterface
     */
    protected $doctrineHelper;

    /**
     * @var LocaleRepositoryInterface
     */
    protected $localeRepository;

    /**
     * @var LocaleFactory
     */
    protected $localeFactory;

    /**
     * @var CurrencyRepositoryInterface
     */
    protected $currencyRepository;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * AddLocaleCommand constructor.
     *
     * @param DoctrineHelperInterface     $doctrineHelper
     * @param LocaleRepositoryInterface   $localeRepository
     * @param LocaleFactory               $localeFactory
     * @param CurrencyRepositoryInterface $currencyRepository
     */
    public function __construct(
        DoctrineHelperInterface $doctrineHelper,
        LocaleRepositoryInterface $localeRepository,
        LocaleFactory $localeFactory,
        CurrencyRepositoryInterface $currencyRepository
    ) {
        parent::__construct();
        $this->doctrineHelper     = $doctrineHelper;
        $this->localeRepository   = $localeRepository;
        $this->localeFactory      = $localeFactory;
        $this->currencyRepository = $currencyRepository;
        $this->propertyAccessor   = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Adds a new locale and copies translatable entities');
        $this->setName('wellcommerce:locale:add');
    }

    /**
     * Executes the actions
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceLocales       = $this->getSourceLocales();
        $defaultSourceLocale = current($sourceLocales);
        $targetLocales       = $this->getTargetLocales($sourceLocales);
        $currencies          = $this->getInstalledCurrencies();
        $helper              = $this->getHelper('question');
        $question            = new ChoiceQuestion(
            sprintf(
                'Please select source locale from which new entities will be copied (defaults to "%s"):',
                $defaultSourceLocale
            ),
            $sourceLocales,
            $defaultSourceLocale
        );

        $sourceLocale = $helper->ask($input, $output, $question);
        $question     = new ChoiceQuestion('Please select target locale to which new entities will be copied:', $targetLocales, null);
        $targetLocale = $helper->ask($input, $output, $question);

        if ($sourceLocale === $targetLocale) {
            throw new LogicException('Source locale cannot be the same as target locale');
        }

        $question             = new ChoiceQuestion('Please select a default currency for new locale:', $currencies, null);
        $targetLocaleCurrency = $helper->ask($input, $output, $question);
        $locale               = $this->createLocale($targetLocale, $targetLocaleCurrency);
        $output->writeln(sprintf('<info>Created a new locale "%s"</info>', $locale->getCode()));

        $this->copyLocaleData($sourceLocale, $locale, $output);

        $this->doctrineHelper->getEntityManager()->flush();
    }

    /**
     * Copies the locale data from source locale to target locale
     *
     * @param string          $sourceLocale
     * @param LocaleInterface $targetLocale
     * @param OutputInterface $output
     */
    protected function copyLocaleData($sourceLocale, LocaleInterface $targetLocale, OutputInterface $output)
    {
        $entityManager = $this->doctrineHelper->getEntityManager();
        $metadata      = $this->doctrineHelper->getAllMetadata();
        foreach ($metadata as $classMetadata) {
            $reflectionClass = $classMetadata->getReflectionClass();
            if ($reflectionClass->implementsInterface(\WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface::class)) {
                $repository = $entityManager->getRepository($reflectionClass->getName());
                $this->copyTranslatableEntities($repository, $sourceLocale, $targetLocale->getCode(), $output);
            }
        }
    }

    /**
     * Copies translatable entities between locales using a repository collection
     *
     * @param EntityRepository $repository
     * @param string           $sourceLocale
     * @param string  $targetLocale
     * @param OutputInterface  $output
     */
    protected function copyTranslatableEntities(
        EntityRepository $repository,
        $sourceLocale,
        $targetLocale,
        OutputInterface $output
    ) {
        $entityManager = $this->doctrineHelper->getEntityManager();
        $criteria      = new Criteria();
        $criteria->where($criteria->expr()->eq('locale', $sourceLocale));
        $collection = $repository->matching($criteria);

        $collection->map(function (LocaleAwareInterface $entity) use ($targetLocale, $entityManager) {
            $duplicate = clone $entity;
            foreach ($entity->getCopyingSensitiveProperties() as $propertyName) {
                $value = sprintf('%s-%s', $this->propertyAccessor->getValue($entity, $propertyName), $targetLocale);
                $this->propertyAccessor->setValue($duplicate, $propertyName, $value);
                $duplicate->setLocale($targetLocale);
                $entityManager->persist($duplicate);
            }
        });

        $output->write(sprintf(
            'Copied <info>%s</info> entities <info>%s</info>',
            $collection->count(),
            $repository->getClassName()
        ), true);

    }

    /**
     * Creates a new locale
     *
     * @param string $localeCode
     *
     * @return LocaleInterface
     */
    protected function createLocale($localeCode, $targetLocaleCurrency)
    {
        $currency = $this->currencyRepository->findOneBy(['code' => $targetLocaleCurrency]);
        if (!$currency instanceof CurrencyInterface) {
            throw new InvalidArgumentException(sprintf('Wrong default currency "%s" was given', $targetLocaleCurrency));
        }

        $locale = $this->localeFactory->create();
        $locale->setCode($localeCode);
        $locale->setEnabled(true);
        $locale->setCurrency($currency);
        $this->doctrineHelper->getEntityManager()->persist($locale);

        return $locale;
    }

    /**
     * @return array
     */
    protected function getInstalledCurrencies()
    {
        $currencies = [];
        $collection = $this->currencyRepository->matching(new Criteria());

        $collection->map(function (CurrencyInterface $currency) use (&$currencies) {
            $currencies[$currency->getCode()] = $currency->getCode();
        });

        return $currencies;
    }

    /**
     * @return array
     */
    protected function getSourceLocales()
    {
        $locales    = [];
        $collection = $this->localeRepository->matching(new Criteria());

        $collection->map(function (LocaleInterface $locale) use (&$locales) {
            $locales[$locale->getCode()] = $locale->getCode();
        });

        return $locales;
    }

    /**
     * @return array
     */
    protected function getTargetCurrencies()
    {
        $locales    = [];
        $collection = $this->localeRepository->matching(new Criteria());

        $collection->map(function (LocaleInterface $locale) use (&$locales) {
            $locales[$locale->getCode()] = $locale->getCode();
        });

        return $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetLocales($sourceLocales)
    {
        $locales    = [];
        $collection = Intl::getLocaleBundle()->getLocaleNames();

        foreach ($collection as $locale => $name) {
            if (!in_array($locale, $sourceLocales)) {
                $locales[$locale] = $name;
            }
        }

        return $locales;
    }
}
