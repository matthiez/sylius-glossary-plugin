<?php

declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Form\Type;

use Ecolos\SyliusGlossaryPlugin\Entity\GlossaryEntryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class GlossaryEntryChoiceType extends AbstractType
{
    /**
     * @var RepositoryInterface
     */
    private $glossaryEntryRepository;

    public function __construct(RepositoryInterface $glossaryEntryRepository)
    {
        $this->glossaryEntryRepository = $glossaryEntryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['multiple'])
            $builder->addModelTransformer(new CollectionToArrayTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => array_reduce(
                $this->glossaryEntryRepository->findBy([], ['name' => 'ASC']),
                function (array $arr, GlossaryEntryInterface $glossaryEntry) {
                    $arr[$glossaryEntry->getName()] = $glossaryEntry->getId();

                    return $arr;
                }, []),
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'ecolos_sylius_glossary_plugin_glossary_entry_choice';
    }
}
