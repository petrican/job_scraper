<?php

namespace App\Utils\Scraper;

use Goutte\Client;


/**
* This class scrapes jobs from spotifyjobs
*/
class ScraperSpotify implements ScraperInterface
{

    private $collectedData = [];

    /**
     * Main scrape logic from Spotify
     *
     * @param string $url
     * @return ScraperInterface|void
     */
    public function scrape(string $url)
    {
        $client        = new Client();
        $crawler       = $client->request('GET', $url);

        $crawler->filter('tbody > tr > td:first-child > a')->each(function ($node) {
            array_push($this->collectedData , [
                'jobUrl'      => $node->attr('href'),
                'jobHeadline' => preg_replace('!\s+!', ' ',
                    preg_replace('/[^ \w]+/', '', $node->text()))
            ]);
        });

        foreach ($this->collectedData as $key => $colItem) {
            $crawler = $client->request('GET', $colItem['jobUrl']);
            $crawler->filter('.column-inner')->each(function ($node) use ($key) {
                $this->collectedData[$key]['jobDescription'] = $node->html();
                $this->collectedData[$key]['jobTargetsExp']  = $this->guessExperience($node->text());
                $this->collectedData[$key]['jobYearsExp']    = $this->guessYears($node->text());
            });
        }

        return $this->collectedData;
    }

    /**
     * Try to guess years
     *
     * @param string $years
     * @return string
     */
    protected function guessYears(string $description) : string
    {
        $filterThreePlus   = [                                      // tune up these for better results
            'experienced', 'agile', 'strong background', 'expertise',
            'director', 'lead','extensive', 'complex'];
        $filterOneTwoYears = [
            'best practices', 'demonstrable knowledge', 'desire to develop',
            'minimum', 'coding practices'
        ];

        if ($this->matchString($description, $filterThreePlus)) {
            $years = '3+';
        } elseif ($this->matchString($description, $filterOneTwoYears)) {
            $years = '1-2';
        } else {
            $years = '0';
        }


        return $years;
    }


    /**
     * Try to guess experience
     *
     * @param string $description
     * @return string
     */
    protected function guessExperience(string $description) : bool
    {
        $poolExperience   = [
            'Senior', 'Engineer', 'Lead', 'Principal'               // tune up this for better results
        ];

        if ($this->matchString($description, $poolExperience)) {
            $experience = true;
        } else {
            $experience = false;
        }


        return $experience;
    }


    /**
     * Match against one of the strings from arr
     * @param string $description
     * @param array $filter
     * @return bool
     */
    protected function matchString(string $description, array $filter)
    {
        foreach ($filter as $filterItem) {
            if (stripos($description, $filterItem) !== false) {
                return true;
            }
        }

        return false;
    }
}
