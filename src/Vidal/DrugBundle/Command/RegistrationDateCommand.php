<?php
namespace Vidal\DrugBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Команда генерации нормальных дат препаратов
 *
 * @package Vidal\DrugBundle\Command
 */
class RegistrationDateCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this->setName('vidal:registration_date')
			->setDescription('Transforms dates of product registration to NULL if its like 0000-00-00 00:00:00');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		ini_set('memory_limit', -1);
		$output->writeln('--- vidal:registrationdate started');

		$em = $this->getContainer()->get('doctrine')->getManager('drug');

		$em->createQuery('
			UPDATE VidalDrugBundle:Product p
			SET p.RegistrationDate = NULL
			WHERE p.RegistrationDate = \'0000-00-00 00:00:00\'
		')->execute();

		$em->createQuery('
			UPDATE VidalDrugBundle:Product p
			SET p.DateOfCloseRegistration = NULL
			WHERE p.DateOfCloseRegistration = \'0000-00-00 00:00:00\'
		')->execute();

		$output->writeln('+++ vidal:registration_date completed!');
	}
}