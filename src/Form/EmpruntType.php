<?php

namespace App\Form;

use App\Entity\Emprunt;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateEmprunt', null, array("widget" => "single_text"))
            ->add('dateRetour', null, array("widget" => "single_text"))
            ->add('livre', null, ["expanded" => true, "query_builder" =>
                function(EntityRepository $er)
                {
                    return $er->getQbLivreOrderByTitre();
                }])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
