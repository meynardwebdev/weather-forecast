<?php

namespace App\Entity;

use App\Repository\WeatherForecastRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeatherForecastRepository::class)
 */
class WeatherForecast
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="date")
     */
    private $forecast_date;

    /**
     * @ORM\Column(type="float")
     */
    private $temperature;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="weatherForecasts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getForecastDate(): ?\DateTimeInterface
    {
        return $this->forecast_date;
    }

    public function setForecastDate(\DateTimeInterface $forecast_date): self
    {
        $this->forecast_date = $forecast_date;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }
}
