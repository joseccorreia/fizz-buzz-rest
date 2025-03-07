<?php

namespace App\Repository;

use App\Entity\FizzBuzzStat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FizzBuzzStat|null find($id, $lockMode = null, $lockVersion = null)
 * @method FizzBuzzStat|null findOneBy(array $criteria, array $orderBy = null)
 * @method FizzBuzzStat[]    findAll()
 * @method FizzBuzzStat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FizzBuzzStatsRepository extends ServiceEntityRepository
{
    /**
     *
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FizzBuzzStat::class);
    }

    /**
     * Saves or updates a request in the database with the specified parameters
     * @param int $int1 The first divisor for the FizzBuzz algorithm
     * @param int $int2 The second divisor for the FizzBuzz algorithm
     * @param int $limite The upper limit of the numbers to iterate through in the FizzBuzz algorithm
     * @param string $str1 The string associated with the first divisor
     * @param string $str2 The string associated with the second divisor
     */
    public function saveRequest(int $int1, int $int2, int $limite, string $str1, string $str2): void
    {
        $entityManager = $this->getEntityManager();
        $existing = $this->findOneBy(['int1' => $int1, 'int2' => $int2, 'limite' => $limite, 'str1' => $str1, 'str2' => $str2]);

        if ($existing) {
            $existing->incrementHits();
        } else {
            $existing = new FizzBuzzStat($int1, $int2, $limite, $str1, $str2);
        }

        $entityManager->persist($existing);
        $entityManager->flush();
    }

    /**
     * Retrieves the most frequently requested record from the database.
     * @return FizzBuzzStat|null The most frequent request or null if no records exist.
     */
    public function getMostFrequentRequest(): ?FizzBuzzStat
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.hits', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
