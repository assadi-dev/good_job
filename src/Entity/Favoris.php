<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FavorisRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FavorisRepository::class)
 */
class Favoris
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"simpleFavoris"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Offres::class, inversedBy="favoris")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"simpleFavoris"})
     */
    private $offre;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="favoris")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"simpleFavoris"})
     * 
     */
    private $candidat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffre(): ?Offres
    {
        return $this->offre;
    }

    public function setOffre(?Offres $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }
}
