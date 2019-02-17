<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends AbstractController
{
    public function index(SerializerInterface $serializer)
    {
        // keep reading for usage examples
        $json = $serializer->serialize(
            $someObject,
            'json', ['groups' => 'group1']
        );
    }
}