<?php


namespace App\Data;


use App\Entity\Category;

class SearchData
{
   public int $page;

    /**
     * @var Category|array
     */
   public $categories = [];

    /**
     * @var null|integer
     */
   public ?int $max;

    /**
     * @var null|integer
     */
    public ?int $min;
}