<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity
 * @Table(name="ecolos_glossary_entry")
 */
class GlossaryEntry implements GlossaryEntryInterface, ResourceInterface, TranslatableInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->glossaries = new ArrayCollection();
    }

    /**
     * @Column(type="integer", nullable=true)
     * @var integer
     */
    private $alias;

    /**
     * @Column(type="text", nullable=true)
     * @var string|null
     */
    private $description;

    /**
     * @Column(name="enabled", type="boolean", nullable=false)
     * @var bool
     */
    private $enabled;

    /**
     * @Column(type="array")
     * @var Collection|int[]
     */
    private $glossaries;

    /**
     * @Column(type="integer")
     * @Id()
     * @GeneratedValue()
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    private $name;

    public function getAlias(): ?int
    {
        return $this->alias;
    }

    public function setAlias(?int $alias): void
    {
        $this->alias = $alias;
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

    public function getGlossaries(): Collection
    {
        return $this->glossaries;
    }

    public function setGlossaries(ArrayCollection $glossaries): void
    {
        foreach ($glossaries->toArray() as $glossary)
            $this->glossaries->add($glossary);
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

    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): GlossaryEntryTranslation
    {
        return new GlossaryEntryTranslation();
    }
}
