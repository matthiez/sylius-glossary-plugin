<?php

namespace Ecolos\SyliusGlossaryPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class GlossaryEntryType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alias', GlossaryEntryChoiceType::class, [
                'required' => false,
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ])
            ->add('glossaries', EntityType::class, [
                'choice_label' => 'name',
                'class' => 'EcolosSyliusGlossaryPlugin:Glossary',
                "multiple" => true,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('u')
                        ->innerJoin("u.translations", "t")
                        ->orderBy('t.name', 'ASC');
                },
                'required' => true,
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => GlossaryEntryTranslationType::class,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ecolos_sylius_glossary_plugin_glossary_entry';
    }
}
