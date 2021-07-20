<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{

     private int|null $maxPrice = null;

     /**
     * @var int|null @Assert\Range(min=10, max=400)
     */
     private int|null $minSurface = null;

     private ArrayCollection $options;

     private ?int $distance = null;

    private ?float $lat = null;

    private ?float $lng = null;

    private ?string $address = null;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
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

    /**
     * @return int|null
     */
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

    /**
     * @return float|null
     */
    public function getLat(): ?float
    {
        return $this->lat;
    }

    /**
     * @param float|null $lat
     * @return PropertySearch
     */
    public function setLat(?float $lat): PropertySearch
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLng(): ?float
    {
        return $this->lng;
    }

    /**
     * @param float|null $lng
     * @return PropertySearch
     */
    public function setLng(?float $lng): PropertySearch
    {
        $this->lng = $lng;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }
}
