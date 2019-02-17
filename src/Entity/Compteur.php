<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass="App\Repository\CompteurRepository")
 * @UniqueEntity(
 * fields={"numero"},
 * message="Compteur déjà utilisé"
 * )
 */
class Compteur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**     
     * @ORM\Column(type="integer",unique=true,name="numero")
     * @Assert\Length(min=4 , minMessage="Numero est de 5 chiffres")
     */
    private $numero;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->numero;
    } 
        public function eraseCredentials(){}
        public function getSalt(){}
        public function getUsername(){}
        public function getRoles()
        {
            return ['ROLE_USER'];
        }
        public function getPassword(){}

}
