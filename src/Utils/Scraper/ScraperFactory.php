<?php

namespace App\Utils\Scraper;

/**
 * This class is just a Scraper factory
 */
class ScraperFactory
{
    /**
     * @param string $url
     * @return ScraperSpotify|null
     */
    static public function getInstance(string $url)
    {
        $scraperInstance = null;

        $type = '';
        if (strpos($url, 'spotifyjobs.com') !== false) {
            $type = 'spotifyType';
        }

        switch ($type) {

            case 'spotifyType':
                $scraperInstance = new ScraperSpotify();
                break;

            // leave room here for other scrapers implementation

            default:
                echo PHP_EOL . 'Currently scraping from ' . $url . ' is not supported.' . PHP_EOL;
        }

        return $scraperInstance;
    }
}
