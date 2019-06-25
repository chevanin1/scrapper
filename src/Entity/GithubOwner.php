<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GithubOwnerRepository")
 */
class GithubOwner
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $github_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $public_repos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GithubRepository", mappedBy="owner")
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGithubId(): ?int
    {
        return $this->github_id;
    }

    public function setGithubId(int $github_id): self
    {
        $this->github_id = $github_id;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPublicRepos(): ?int
    {
        return $this->public_repos;
    }

    public function setPublicRepos(?int $public_repos): self
    {
        $this->public_repos = $public_repos;

        return $this;
    }

    /**
     * @return Collection|GithubRepository[]
     */
    public function getRepository(): Collection
    {
        return $this->repository;
    }

    public function addRepository(GithubRepository $repository): self
    {
        if (!$this->repository->contains($repository)) {
            $this->repository[] = $repository;
            $repository->setOwner($this);
        }

        return $this;
    }

    public function removeRepository(GithubRepository $repository): self
    {
        if ($this->repository->contains($repository)) {
            $this->repository->removeElement($repository);
            // set the owning side to null (unless already changed)
            if ($repository->getOwner() === $this) {
                $repository->setOwner(null);
            }
        }

        return $this;
    }
}
