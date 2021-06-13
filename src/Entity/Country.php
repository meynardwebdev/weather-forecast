<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iso_code;

    /**
     * @ORM\OneToMany(targetEntity=WeatherForecast::class, mappedBy="country")
     */
    private $weatherForecasts;

    public function __construct()
    {
        $this->weatherForecasts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsoCode(): ?string
    {
        return $this->iso_code;
    }

    public function setIsoCode(string $iso_code): self
    {
        $this->iso_code = $iso_code;

        return $this;
    }

    /**
     * @return Collection|WeatherForecast[]
     */
    public function getWeatherForecasts(): Collection
    {
        return $this->weatherForecasts;
    }

    public function addWeatherForecast(WeatherForecast $weatherForecast): self
    {
        if (!$this->weatherForecasts->contains($weatherForecast)) {
            $this->weatherForecasts[] = $weatherForecast;
            $weatherForecast->setCountry($this);
        }

        return $this;
    }

    public function removeWeatherForecast(WeatherForecast $weatherForecast): self
    {
        if ($this->weatherForecasts->removeElement($weatherForecast)) {
            // set the owning side to null (unless already changed)
            if ($weatherForecast->getCountry() === $this) {
                $weatherForecast->setCountry(null);
            }
        }

        return $this;
    }
}
