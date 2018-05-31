<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
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
    private $jobUrl;

    /**
     * @ORM\Column(type="text")
     */
    private $jobHeadline;

    /**
     * @ORM\Column(type="text")
     */
    private $jobDescription;

    /**
     * @ORM\Column(type="boolean")
     */
    private $jobTargetsExperienced;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $jobYearsExp;

    public function getId()
    {
        return $this->id;
    }

    public function getJobUrl(): ?string
    {
        return $this->jobUrl;
    }

    public function setJobUrl(string $jobUrl): self
    {
        $this->jobUrl = $jobUrl;

        return $this;
    }

    public function getJobHeadline(): ?string
    {
        return $this->jobHeadline;
    }

    public function setJobHeadline(string $jobHeadline): self
    {
        $this->jobHeadline = $jobHeadline;

        return $this;
    }

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function setJobDescription(string $jobDescription): self
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    public function getJobTargetsExperienced(): ?bool
    {
        return $this->jobTargetsExperienced;
    }

    public function setJobTargetsExperienced(bool $jobTargetsExperienced): self
    {
        $this->jobTargetsExperienced = $jobTargetsExperienced;

        return $this;
    }

    public function getJobYearsExp(): ?string
    {
        return $this->jobYearsExp;
    }

    public function setJobYearsExp(?string $jobYearsExp): self
    {
        $this->jobYearsExp = $jobYearsExp;

        return $this;
    }
}
