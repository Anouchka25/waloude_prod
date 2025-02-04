<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnfantRepository")
 */
class Enfant
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datenaissance;



    /*
     * @ORM\Column(type="string", length=255)
    
    private $lien_affiliation;
    */
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Souscripteur", inversedBy="enfants")
     */
    private $souscripteur;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDateNaissance(\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

/*     public function getLienAffiliation(): ?string
    {
        return $this->lien_affiliation;
    }

    public function setLienAffiliation(string $lien_affiliation): self
    {
        $this->lien_affiliation = $lien_affiliation;

        return $this;
    } */

    public function getSouscripteur(): ?Souscripteur
    {
        return $this->souscripteur;
    }

    public function setSouscripteur(?Souscripteur $souscripteur): self
    {
        $this->souscripteur = $souscripteur;

        return $this;
    }

    public function __toString()
    {
        return $this->nom." ".$this->prenom;
    }
}
