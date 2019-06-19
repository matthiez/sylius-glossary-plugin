<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @Entity
 * @Table(name="ecolos_glossary")
 */
class Glossary implements GlossaryInterface, ResourceInterface, TranslatableInterface
{
    /**
     * @Column(name="enabled", type="boolean", nullable=false)
     * @var bool
     */
    protected $enabled;

    /**
     * @ManyToMany(targetEntity="Ecolos\SyliusGlossaryPlugin\Entity\GlossaryEntry", mappedBy="glossaries")
     * @JoinTable(name="ecolos_glossary_entries")
     */
    protected $entries;

    /**
     * @Column(type="integer")
     * @Id()
     * @GeneratedValue()
     * @var int
     */
    private $id;

    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->entries = new ArrayCollection();
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(string $name): void
    {
        $this->getTranslation()->setName($name);
    }

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(?string $description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    public function getSlug(): string
    {
        return $this->getTranslation()->getSlug();
    }

    public function setSlug(string $slug): void
    {
        $this->getTranslation()->setSlug($slug);
    }

    public function getEntries(): ArrayCollection
    {
        return $this->entries;
    }

    public function setEntries($entries): void
    {
        if ($entries instanceof ArrayCollection) {
            $entries = $entries->toArray();
        }

        foreach ($entries as $entry) {
            array_push($this->entries, $entry);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): GlossaryTranslation
    {
        return new GlossaryTranslation();
    }
}
