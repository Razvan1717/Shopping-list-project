<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ShoppingListType extends AbstractType
{
    /**
     * {@inheritdoc}s
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('event', EntityType::class, [
            'class' => 'AppBundle:Event',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('e')
                    ->where('e.shoppingList IS  NULL');},
            'choice_label' => 'name'
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ShoppingList'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_shoppinglist';
    }


}
