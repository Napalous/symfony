<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AbonnementRepository")
 */
class Abonnement
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
    private $contrat;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAb;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    private $cumulAnc;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=5)
     */
    private $cumulNouv;

    /**
     * @Groups({"rest"})
     * @var integer
     * @ORM\OneToOne(targetEntity="App\Entity\Compteur", cascade={"persist", "remove"})
     */
    private $compteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContrat(): ?string
    {
        return $this->contrat;
    }

    public function setContrat(string $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function getDateAb(): ?\DateTimeInterface
    {
        return $this->dateAb;
    }

    public function setDateAb(\DateTimeInterface $dateAb): self
    {
        $this->dateAb = $dateAb;

        return $this;
    }

    public function getCumulAnc()
    {
        return $this->cumulAnc;
    }

    public function setCumulAnc($cumulAnc): self
    {
        $this->cumulAnc = $cumulAnc;

        return $this;
    }

    public function getCumulNouv()
    {
        return $this->cumulNouv;
    }

    public function setCumulNouv($cumulNouv): self
    {
        $this->cumulNouv = $cumulNouv;

        return $this;
    }

    public function getCompteur(): ?Compteur
    {
        return $this->compteur;
    }

    public function setCompteur(?Compteur $compteur): self
    {
        $this->compteur = $compteur;

        return $this;
    }
    public function __toString()
    {
        return $this->contrat;
    }
}
