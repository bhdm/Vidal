<?php
namespace Vidal\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Команда генерации автодополнения противопоказаний Contraindication
 *
 * @package Vidal\MainBundle\Command
 */
class AutocompleteContraindicationCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this->setName('vidal:autocomplete_contraindication')
			->setDescription('Creates autocomplete_contraindication type in Elastica');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('--- vidal:autocomplete_contraindication started');

		$em = $this->getContainer()->get('doctrine')->getManager();

		$contraindications = $em->getRepository('VidalMainBundle:Contraindication')->findAll();

		$elasticaClient = new \Elastica\Client();
		$elasticaIndex  = $elasticaClient->getIndex('website');
		$elasticaType   = $elasticaIndex->getType('autocomplete_contraindication');

		# delete if exists
		if ($elasticaType->exists()) {
			$elasticaType->delete();
		}

		# Define mapping
		$mapping = new \Elastica\Type\Mapping();
		$mapping->setType($elasticaType);

		# Set mapping
		$mapping->setProperties(array(
			'name' => array('type' => 'string', 'include_in_all' => TRUE),
		));

		# Send mapping to type
		$mapping->send();

		# записываем на сервер документы автодополнения
		$documents = array();

		for ($i = 0; $i < count($contraindications); $i++) {
			$documents[] = new \Elastica\Document($i + 1, array('name' => $contraindications[$i]['RusName']));

			if ($i && $i % 500 == 0) {
				$elasticaType->addDocuments($documents);
				$elasticaType->getIndex()->refresh();
				$documents = array();
			}
		}

		$elasticaType->getIndex()->refresh();

		$output->writeln("+++ vidal:autocomplete_contraindication loaded $i documents!");
	}
}