<?php

namespace App\Utils\Scraper;

/**
 * Interface for all scrapers
 */
interface ScraperInterface
{
    /**
     * Scrapes jobs from the url given as parameter
     *
     * @param string $url - Url from where to scrape
     *
     * @return ScraperInterface self Object
     */
    public function scrape(string $url);
}
