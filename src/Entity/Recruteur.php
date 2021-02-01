<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RecruteurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=RecruteurRepository::class)
 */
class Recruteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"simpleRecruteur","simpleCandidatures"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"simpleRecruteur"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"simpleRecruteur"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"simpleRecruteur"})
     */
    private $birth;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"simpleRecruteur"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"simpleRecruteur"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"simpleRecruteur"})
     */
    private $entreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"simpleRecruteur"})
     */
    private $avatar;



    /**
     * @ORM\Column(type="datetime")
     * @Groups({"simpleRecruteur"})
     */
    private $create_at;



    /**
     * @ORM\OneToMany(targetEntity=Candidature::class, mappedBy="recruteur")
     */
    private $candidatures;

    /**
     * @ORM\OneToOne(targetEntity=Connection::class, cascade={"persist", "remove"})
     * @Groups({"simpleRecruteur"})
     */
    private $connexion;

    /**
     * @ORM\OneToMany(targetEntity=Offres::class, mappedBy="auteur")
     */
    private $offres;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
        $this->offres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getBirth(): ?string
    {
        return $this->birth;
    }

    public function setBirth(string $birth): self
    {
        $this->birth = $birth;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }


    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    /**
     * @return Collection|Candidature[]
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setRecruteur($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getRecruteur() === $this) {
                $candidature->setRecruteur(null);
            }
        }

        return $this;
    }

    public function getConnexion(): ?Connection
    {
        return $this->connexion;
    }

    public function setConnexion(?Connection $connexion): self
    {
        $this->connexion = $connexion;

        return $this;
    }

    /**
     * @return Collection|Offres[]
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offres $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setAuteur($this);
        }

        return $this;
    }

    public function removeOffre(Offres $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getAuteur() === $this) {
                $offre->setAuteur(null);
            }
        }

        return $this;
    }
}
