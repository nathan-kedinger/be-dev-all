<?php

namespace App\Entity;

use App\Repository\LanguagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguagesRepository::class)]
class Languages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'language', targetEntity: UserLanguage::class)]
    private Collection $userLanguages;

    public function __construct()
    {
        $this->userLanguages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, UserLanguage>
     */
    public function getUserLanguages(): Collection
    {
        return $this->userLanguages;
    }

    public function addUserLanguage(UserLanguage $userLanguage): self
    {
        if (!$this->userLanguages->contains($userLanguage)) {
            $this->userLanguages->add($userLanguage);
            $userLanguage->setLanguage($this);
        }

        return $this;
    }

    public function removeUserLanguage(UserLanguage $userLanguage): self
    {
        if ($this->userLanguages->removeElement($userLanguage)) {
            // set the owning side to null (unless already changed)
            if ($userLanguage->getLanguage() === $this) {
                $userLanguage->setLanguage(null);
            }
        }

        return $this;
    }
}
