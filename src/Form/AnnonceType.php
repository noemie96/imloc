<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends AbstractType
{

        private function getConfiguration($label,$placeholder, $options=[]){
            return array_merge([
                
                    'label'=>$label,
                    'attr'=>[
                        'placeholder'=>$placeholder
                    ]
                    ], $options);
        }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[ //exemple sans getConfiguration
                'label'=>"Titre",
                'attr'=>[
                    'placeholder'=>"titre de votre annonce"
                ]
            ])
            ->add('slug', TextType::class, $this->getConfiguration('slug','Adresse web(automatique)',[
                'required'=>false
            ]))//ex avec getconfig
            ->add('rooms', IntegerType::class, $this->getConfiguration('Nombre de chambre','Donnez le nombre de chambre disponibles'))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix par nuit','indiquer le prix que vous voulez pour une nuit'))
            ->add('introduction', TextType::class, $this->getConfiguration('introduction','Donnez une description globale de l\'annonce'))
            ->add('content', TextareaType::class, $this->getConfiguration('Description','Description détaillée de votre bien'))
            ->add('coverImage', UrlType::class, $this->getConfiguration('URL de l\'image','Donnez l\'adresse de votre image'))
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type'=> ImageType::class,
                    'allow_add'=> true,//permet d'ajouter de nouveaux éléments et ajouter un data_prototype
                    'allow_delete'=> true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
