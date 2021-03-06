<?php
namespace Vidal\DrugBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompanyCountryCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this->setName('vidal:company_country');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		ini_set('memory_limit', -1);
		$output->writeln('--- vidal:company_country started');

		$em        = $this->getContainer()->get('doctrine')->getManager('drug');

		$em->createQuery("
			UPDATE VidalDrugBundle:Company c
			SET c.CountryCode = NULL
			WHERE c.CountryCode = ''
		")->execute();

		$output->writeln('+++ vidal:company_country completed');
	}
}