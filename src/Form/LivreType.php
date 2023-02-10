<?php

namespace App\Form;

use App\Entity\Livre;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('quatrieme', null, array("attr" => array(
                "rows" => 7,
                "cols" => 23
                )))
            ->add('dateParution', null, array("widget" => "single_text"))
            ->add('empruntPossible')
            ->add('auteur', null, ["expanded" => true, "query_builder" => function(EntityRepository $er)
            {
                return $er->getQbAuteurOrderByNom();
            }])
        ;

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();
                if (count($data->getAuteur()) == 0)
                {
                    $event->getForm()->get("auteur")
                    ->addError(
                        new \Symfony\Component\Form\FormError(
                            'Il faut au moins un auteur'
                        )
                    );
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
