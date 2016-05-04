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

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Intl\Intl;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\CurrencyBundle\DataSet\Admin\CurrencyDataSet;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\LocaleBundle\Copier\LocaleCopierInterface;
use WellCommerce\Bundle\LocaleBundle\DataSet\Admin\LocaleDataSet;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;

/**
 * Class AddLocaleCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class AddLocaleCommand extends ContainerAwareCommand
{
    /**
     * @var ManagerInterface
     */
    protected $localeManager;
    
    /**
     * @var LocaleDataSet
     */
    protected $localeDataSet;
    
    /**
     * @var CurrencyDataSet
     */
    protected $currencyDataSet;
    
    /**
     * @var array
     */
    protected $installedLocales = [];
    
    /**
     * @var array
     */
    protected $installedCurrencies = [];
    
    /**
     * @var array
     */
    protected $availableLocales = [];
    
    protected function configure()
    {
        $this->setDescription('Adds a new locale and copies translatable entities');
        $this->setName('wellcommerce:locale:add');
    }
    
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->localeManager       = $this->getLocaleManager();
        $this->localeDataSet       = $this->getLocaleDataSet();
        $this->currencyDataSet     = $this->getCurrencyDataSet();
        $this->installedLocales    = $this->getInstalledLocales();
        $this->installedCurrencies = $this->getInstalledCurrencies();
        $this->availableLocales    = $this->getAvailableLocales();
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceLocale   = $this->chooseSourceLocale($input, $output);
        $targetLocale   = $this->chooseTargetLocale($input, $output);
        $targetCurrency = $this->chooseTargetCurrency($input, $output);
        
        $locale = $this->createLocale($targetLocale, $targetCurrency);
        $output->writeln(sprintf('<info>Created a new locale "%s"</info>', $locale->getCode()));
        
        $this->copyLocaleData($sourceLocale, $targetLocale);
        
        $output->writeln(sprintf('<info>Finished copying "%s" data</info>', $locale->getCode()));
    }
    
    private function createLocale(string $localeCode, string $targetLocaleCurrency) : LocaleInterface
    {
        $currency = $this->getTargetCurrency($targetLocaleCurrency);
        /** @var LocaleInterface $locale */
        $locale = $this->localeManager->initResource();
        $locale->setCode($localeCode);
        $locale->setEnabled(true);
        $locale->setCurrency($currency);
        $this->localeManager->createResource($locale);
        
        return $locale;
    }

    private function findLocale(string $code) : LocaleInterface
    {
        return $this->localeManager->getRepository()->findOneBy(['code' => $code]);
    }

    private function copyLocaleData(string $sourceLocaleCode, string $targetLocaleCode)
    {
        $sourceLocale = $this->findLocale($sourceLocaleCode);
        $targetLocale = $this->findLocale($targetLocaleCode);
        
        $this->getLocaleCopier()->copyLocaleData($sourceLocale, $targetLocale);
    }
    
    private function getTargetCurrency($targetCurrency) : CurrencyInterface
    {
        return $this->getContainer()->get('currency.repository')->findOneBy(['code' => $targetCurrency]);
    }
    
    private function chooseSourceLocale(InputInterface $input, OutputInterface $output) : string
    {
        $defaultLocale = current($this->installedLocales);
        $question      = new ChoiceQuestion(
            sprintf(
                'Please select source locale from which new entities will be copied (defaults to "%s"):',
                $defaultLocale
            ),
            $this->installedLocales,
            $defaultLocale
        );
        
        $sourceLocale = $this->getHelper('question')->ask($input, $output, $question);
        
        return $sourceLocale;
    }
    
    private function chooseTargetLocale(InputInterface $input, OutputInterface $output) : string
    {
        $question     = new ChoiceQuestion('Please select target locale to which new entities will be copied:', $this->availableLocales);
        $targetLocale = $this->getHelper('question')->ask($input, $output, $question);
        
        return $targetLocale;
    }
    
    private function chooseTargetCurrency(InputInterface $input, OutputInterface $output) : string
    {
        $question             = new ChoiceQuestion('Please select a default currency for new locale:', $this->installedCurrencies);
        $targetLocaleCurrency = $this->getHelper('question')->ask($input, $output, $question);
        
        return $targetLocaleCurrency;
    }
    
    private function getInstalledCurrencies() : array
    {
        return $this->currencyDataSet->getResult('select', ['order_by' => 'code'], [
            'label_column' => 'code',
            'value_column' => 'code'
        ]);
    }
    
    private function getInstalledLocales() : array
    {
        return $this->localeDataSet->getResult('select', ['order_by' => 'code'], [
            'label_column' => 'code',
            'value_column' => 'code'
        ]);
    }
    
    private function getAvailableLocales() : array
    {
        $locales    = [];
        $collection = Intl::getLocaleBundle()->getLocaleNames();
        
        foreach ($collection as $locale => $name) {
            if (!in_array($locale, $this->installedLocales)) {
                $locales[$locale] = $name;
            }
        }
        
        return $locales;
    }
    
    private function getLocaleDataSet() : LocaleDataSet
    {
        return $this->getContainer()->get('locale.dataset.admin');
    }
    
    private function getCurrencyDataSet() : CurrencyDataSet
    {
        return $this->getContainer()->get('currency.dataset.admin');
    }
    
    private function getLocaleManager() : ManagerInterface
    {
        return $this->getContainer()->get('locale.manager');
    }

    private function getLocaleCopier() : LocaleCopierInterface
    {
        return $this->getContainer()->get('locale.copier');
    }
}
