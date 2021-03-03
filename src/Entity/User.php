<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"email"},
 *  message= "L'email que vous avez indiqué est déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     * min="3",
     * max="12",
     * minMessage="Votre mot de passe doit faire minimum 8 caractères",
     * maxMessage="Votre mot de passe doit faire maximum 12 caractères"
     * )
     * @Assert\EqualTo(propertyPath="confirmPassword", message="Vous n'avez pas tapé le même mot de passe")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password")
     */
    public $confirmPassword;

    /**
     *  @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Souscripteur", mappedBy="user", cascade={"remove"}, inversedBy="user")
     */
    protected $souscripteur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PhotoUser", mappedBy="user", cascade={"persist", "remove"})
     */
    private $photoUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function __toString() {
        return $this->getUsername();
      }

/*     public function getConfirmPassword(): ?string
    {
        return $this->password;
    }

    public function setConfirmPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    } */

    public function eraseCredentials()
    {

    }

    public function getSalt()
    {

    }

     public function getRoles(): ?array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

     public function getResetToken(): ?string
     {
         return $this->resetToken;
     }

     public function setResetToken(?string $resetToken): self
     {
         $this->resetToken = $resetToken;

         return $this;
     }
    
    /*
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
 */

    public function getSouscripteur(): ?Souscripteur
    {
        return $this->souscripteur;
    }

    public function setSouscripteur(Souscripteur $souscripteur): self
    {
        $this->souscripteur = $souscripteur;

        // set the owning side of the relation if necessary
        if ($souscripteur->getUser() !== $this) {
            $souscripteur->setUser($this);
        }

        return $this;
    }

    public function getPhotoUser(): ?PhotoUser
    {
        return $this->photoUser;
    }

    public function setPhotoUser(PhotoUser $photoUser): self
    {
        $this->photoUser = $photoUser;

        // set the owning side of the relation if necessary
        if ($photoUser->getUser() !== $this) {
            $photoUser->setUser($this);
        }

        return $this;
    }

}
