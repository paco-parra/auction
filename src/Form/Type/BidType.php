<?php
declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Bids;
use App\Entity\Lots;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BidType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('offer', NumberType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => '1200€',
                    'class' => 'form-control'
                ]
            ])
            ->add('lot', EntityType::class, [
                'label' => false,
                'class' => Lots::class,
                'data' => $options['lot'],
                'attr' => [
                    'class' => 'hidden'
                ]
            ])
            ->add('user', EntityType::class, [
                'label' => false,
                'class' => User::class,
                'data' => $options['user'],
                'attr' => [
                    'class' => 'hidden'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'lot_view.make_bid',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'lot' => null,
            'user' => null,
            'data_class' => Bids::class,
        ]);
    }
}
