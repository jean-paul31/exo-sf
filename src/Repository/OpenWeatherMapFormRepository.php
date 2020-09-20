<?php

namespace App\Repository;

use App\Entity\OpenWeatherMapForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OpenWeatherMapForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpenWeatherMapForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpenWeatherMapForm[]    findAll()
 * @method OpenWeatherMapForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpenWeatherMapFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpenWeatherMapForm::class);
    }

}
