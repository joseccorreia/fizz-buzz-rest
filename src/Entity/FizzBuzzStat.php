<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a FizzBuzzStat entity.
 * This entity is used to store parameters for the FizzBuzz computation and the number of times a specific
 * configuration has been queried.
 */
#[ORM\Entity(repositoryClass: "App\\Repository\\FizzBuzzStatsRepository")]
class FizzBuzzStat
{
    /**
     * @var int The unique identifier of the entity
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    /**
     * @var int The first divisor for the FizzBuzz algorithm
     */
    #[ORM\Column(type: "integer")]
    private int $int1;

    /**
     * @var int The second divisor for the FizzBuzz algorithm
     */
    #[ORM\Column(type: "integer")]
    private int $int2;

    /**
     * @var int The upper limit of the numbers to iterate through in the FizzBuzz algorithm
     */
    #[ORM\Column(type: "integer")]
    private int $limite;

    /**
     * @var string The string associated with the first divisor
     */
    #[ORM\Column(type: "string")]
    private string $str1;

    /**
     * @var string The string associated with the second divisor
     */
    #[ORM\Column(type: "string")]
    private string $str2;

    /**
     * @var int The number of times this specific FizzBuzz configuration has been requested
     */
    #[ORM\Column(type: "integer")]
    private int $hits = 1;

    /** */
    public function __construct(int $int1, int $int2, int $limite, string $str1, string $str2)
    {
        $this->int1 = $int1;
        $this->int2 = $int2;
        $this->limite = $limite;
        $this->str1 = $str1;
        $this->str2 = $str2;
    }

    /** */
    public function incrementHits(): static
    {
        $this->hits++;
        return $this;
    }

    /** */
    public function getId(): int
    {
        return $this->id;
    }

    /** */
    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    /** */
    public function getInt1(): int
    {
        return $this->int1;
    }

    /** */
    public function setInt1(int $int1): static
    {
        $this->int1 = $int1;
        return $this;
    }

    /** */
    public function getInt2(): int
    {
        return $this->int2;
    }

    /** */
    public function setInt2(int $int2): static
    {
        $this->int2 = $int2;
        return $this;
    }

    /** */
    public function getLimite(): int
    {
        return $this->limite;
    }

    /** */
    public function setLimite(int $limite): static
    {
        $this->limite = $limite;
        return $this;
    }

    /** */
    public function getStr1(): string
    {
        return $this->str1;
    }

    /** */
    public function setStr1(string $str1): static
    {
        $this->str1 = $str1;
        return $this;
    }

    /** */
    public function getStr2(): string
    {
        return $this->str2;
    }

    /** */
    public function setStr2(string $str2): static
    {
        $this->str2 = $str2;
        return $this;
    }

    /** */
    public function getHits(): int
    {
        return $this->hits;
    }

    /** */
    public function setHits(int $hits): static
    {
        $this->hits = $hits;
        return $this;
    }

}
