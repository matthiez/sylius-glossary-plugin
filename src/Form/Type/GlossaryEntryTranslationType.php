<?php
declare(strict_types=1);

namespace Ecolos\SyliusGlossaryPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GlossaryEntryTranslationType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, ['required' => false])
            ->add('name', TextType::class)
            ->add('slug', TextType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => function (FormInterface $form) {
                $groups = ['Default'];

                if (!is_int($form->getData()['alias'])) { // then we want password to be required
                    $groups[] = 'VAL_PAIR_DESC_ALIAS';
                }

                return $groups;
            },
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ecolos_sylius_glossary_plugin_glossary_entry_translation';
    }
}
