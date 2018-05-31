<?php

namespace App\Command;

use App\Utils\Scraper\ScraperFactory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ScraperCommand
 * @package App\Command
 */
class ScraperCommand extends ContainerAwareCommand {

    /**
     * Configure the commannd
     */
    protected function configure() {
        $this->setName('scraper:scrape')->addArgument('url', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $em        = $this->getContainer()->get('doctrine')->getManager();
        $urlInput  = $input->getArgument('url');

        if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $urlInput)) {
            echo PHP_EOL . 'Huston we have a Broblem :). You must specify a valid URL. Go back and retry.' . PHP_EOL;
            die();
        }

        if ($urlInput) {
            $output->writeln(PHP_EOL . 'Scraping from ' . $urlInput);
            $scraperInstance = ScraperFactory::getInstance($input->getArgument('url'));
            if ($scraperInstance === null) {
                echo PHP_EOL . "Cannot find this scraper implementation..." . PHP_EOL . PHP_EOL;
            } else {
                $collectedData = $scraperInstance->scrape($urlInput);
                $em->getRepository('App:Job')->storeScrapedData($collectedData);
            }
        } else {
            $output->writeln('Scraper called without URL arguments passed!');
        }
    }
}