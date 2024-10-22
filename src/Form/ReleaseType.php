<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Release;
use App\Repository\ArtistRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReleaseType extends AbstractType
{
    public function __construct(
        private Security $security,
    ) {}
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $builder
            ->add('title', null, [
                'label' => 'Release Title',
                'attr' => [
                    'placeholder' => 'Enter the release title'
                ],
            ])
            ->add('thumbnailUrl', UrlType::class, [
                'label' => 'Thumbnail URL',
                'attr' => [
                    'placeholder' => 'Enter the release thumbnail URL'
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Release Type',
                'choices' => [
                    'Album' => Release::ALBUM,
                    'EP' => Release::EP,
                    'Single' => Release::SINGLE,
                ],
            ])
            ->add('releasedAt', null, [
                'label' => 'Release Date',
                'widget' => 'single_text',
            ])
            ->add('artist', EntityType::class, [
                'label' => 'Artist',
                'class' => Artist::class,
                'choice_label' => 'name',
                'query_builder' => fn(ArtistRepository $repository) 
                    => $repository->createQueryBuilder('a')
                        ->join('a.owner', 'o')
                        ->where('o = :owner')
                        ->setParameter('owner', $user)
                        ->orderBy('a.name', 'ASC'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Release::class,
        ]);
    }
}
