<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GithubRepositoryRepository")
 */
class GithubRepository
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
    private $full_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $owner_github_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $owner_github_api_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $language;

    /**
     * @ORM\Column(type="integer")
     */
    private $forks;

    /**
     * @ORM\Column(type="float")
     */
    private $score;

    /**
     * @ORM\Column(type="boolean")
     */
    private $owner_loaded;

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

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getOwnerGithubId(): ?int
    {
        return $this->owner_github_id;
    }

    public function setOwnerGithubId(int $owner_github_id): self
    {
        $this->owner_github_id = $owner_github_id;

        return $this;
    }

    public function getOwnerGithubApiUrl(): ?string
    {
        return $this->owner_github_api_url;
    }

    public function setOwnerGithubApiUrl(string $owner_github_api_url): self
    {
        $this->owner_github_api_url = $owner_github_api_url;

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

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getForks(): ?int
    {
        return $this->forks;
    }

    public function setForks(int $forks): self
    {
        $this->forks = $forks;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getOwnerLoaded(): ?bool
    {
        return $this->owner_loaded;
    }

    public function setOwnerLoaded(bool $owner_loaded): self
    {
        $this->owner_loaded = $owner_loaded;

        return $this;
    }
}
