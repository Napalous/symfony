<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mois;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    private $consommation;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reglement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Abonnement")
     */
    private $abonnement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): self
    {
        $this->mois = $mois;

        return $this;
    }

    public function getConsommation()
    {
        return $this->consommation;
    }

    public function setConsommation($consommation): self
    {
        $this->consommation = $consommation;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getReglement(): ?bool
    {
        return $this->reglement;
    }

    public function setReglement(bool $reglement): self
    {
        $this->reglement = $reglement;

        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->abonnement;
    }

    public function setAbonnement(?Abonnement $abonnement): self
    {
        $this->abonnement = $abonnement;

        return $this;
    }
    public function __toString()
    {
        return $this->mois;
    }
}
