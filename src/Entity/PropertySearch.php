<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch {

    private ?int $maxPrice = null;

    /**
     * @Assert\Range(min=10, max=400)
     */
    private ?int $minSurface = null;

    private ArrayCollection $options;

    private ?int $distance = null;

    private ?float $lat = null;

    private ?string $address = null;

    private ?float $lng = null;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|$maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @param int $minSurface
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     * @return PropertySearch
     */
    public function setDistance(int $distance): PropertySearch
    {
        $this->distance = $distance;
        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     * @return PropertySearch
     */
    public function setLat(float $lat): PropertySearch
    {
        $this->lat = $lat;
        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     * @return PropertySearch
     */
    public function setLng(float $lng): PropertySearch
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return PropertySearch
     */
    public function setAddress(string $address): PropertySearch
    {
        $this->address = $address;
        return $this;
    }
}
