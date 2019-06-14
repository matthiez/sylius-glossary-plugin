<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Resource\Model\AbstractTranslation;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @Entity
 * @Table(name="ecolos_glossary_entry_translation")
 */
class GlossaryEntryTranslation extends AbstractTranslation implements ResourceInterface
{
    /**
     * @Column(type="text", nullable=true)
     * @var string
     */
    private $description;

    /**
     * @Column(type="integer")
     * @Id()
     * @GeneratedValue()
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @Column(type="string")
     * @var string
     */
    private $slug;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
