<?php

namespace App\Form;

use App\Entity\Auteur;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

//use Symfony\Component\Form\FormTypeInterface;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance', null, array("widget" => "single_text"))
            ->add('nationalite')
            ->add('livres', null, ["expanded" => true])
        ;

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();
                if (count($data->getLivres()) == 0)
                {
                    $event->getForm()->get("livres")
                    ->addError(
                        new \Symfony\Component\Form\FormError(
                            'Il faut au moins un livre'
                        )
                    );
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
