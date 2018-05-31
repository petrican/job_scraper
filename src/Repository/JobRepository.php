<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function storeScrapedData(array $collectedData)
    {
        foreach($collectedData as $scraped) {
            // write data only if this wasn't scraped already
            if (empty($this->findBy(['jobUrl' => $scraped['jobUrl']]))) {
                echo PHP_EOL . 'Writing to db data from => ' . $scraped['jobUrl'] . PHP_EOL;
                echo 'Title => ' . $scraped['jobHeadline'] . PHP_EOL;
                echo 'Description => ' . $scraped['jobDescription'] . PHP_EOL . PHP_EOL;
                echo PHP_EOL . '===============================================================' . PHP_EOL;
                $newJob = new Job();
                $newJob->setJobUrl($scraped['jobUrl']);
                $newJob->setJobHeadline($scraped['jobHeadline']);
                $newJob->setJobDescription($scraped['jobDescription']);
                $newJob->setJobTargetsExperienced($scraped['jobTargetsExp']);
                $newJob->setJobYearsExp($scraped['jobYearsExp']);
                $this->_em->persist($newJob);
            } else {
                echo "Not adding " . $scraped['jobUrl'] . ' because already exists in DB ...' . PHP_EOL;
            }
            $this->_em->flush();
        }
    }
//    /**
//     * @return Job[] Returns an array of Job objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Job
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
