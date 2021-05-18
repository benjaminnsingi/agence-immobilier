<?php


namespace App\Services;


use App\Entity\Picture;
use App\Entity\Property;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ManagePicturesService
{
   private ParameterBagInterface $params;

   public function __construct(ParameterBagInterface $params)
   {
       $this->params = $params;
   }

   public function add(array $pictures, Property $property)
   {
       // We loop on the images
       foreach ($pictures as $picture) {
           // We generate a new file name
           $file = md5(uniqid()).'.'.$picture->guessExtension();

           // We copy the file in the uploads folder
           $picture->move(
               $this->params->get('images_directory'),
               $file
           );

           // We create the image in the database
           $image = new Picture();
           $image->setName($file);
           $property->addPicture($image);
       }
   }
}