<?php

namespace App\Repository;

use App\Entity\Country;
use App\Entity\WeatherForecast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WeatherForecast|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherForecast|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherForecast[]    findAll()
 * @method WeatherForecast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherForecastRepository extends ServiceEntityRepository
{
    /** @var EntityManagerInterface */
    private $manager;

    /**
     * WeatherForecastRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, WeatherForecast::class);
        $this->manager = $manager;
    }

    public function isWeatherForecastExists($city, $country)
    {
        return $this->createQueryBuilder('w')
            ->where('w.city = :city')
            ->andWhere('w.country = :country')
            ->setParameter('city', $city)
            ->setParameter('country', $country)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $city
     * @param Country $country
     * @param float $temperature
     *
     * @return void
     */
    public function saveWeatherForecast(string $city, Country $country, float $temperature): void
    {
        $newWeatherForecast = new WeatherForecast();
        $newWeatherForecast
            ->setCity($city)
            ->setCountry($country)
            ->setTemperature($temperature)
            ->setForecastDate(new \DateTime());

        $this->manager->persist($newWeatherForecast);
        $this->manager->flush();
    }
}
