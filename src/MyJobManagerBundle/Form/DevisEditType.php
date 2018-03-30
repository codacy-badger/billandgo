<?php

namespace MyJobManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use MyJobManagerBundle\Form\DevisLineType;
use MyJobManagerBundle\Entity\ClientContact;
use Doctrine\ORM\EntityRepository;

class DevisEditType extends AbstractType
{
    private $_uid;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->_uid = $options['uid'];
        $builder
            ->add('creation', DateTimeType::class, array(
                'required' => 'true',
                'widget' => 'single_text',
                'html5' => false,
                'data' => new \DateTime()
            ))
            ->add('validity', DateTimeType::class, array(
                'required' => 'true',
                'widget' => 'single_text',
                'html5' => false,
                'data' => new \DateTime('+1month')
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array('class' => 'tinymce')
            ))
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyJobManagerBundle\Entity\Devis',
            'uid' => NULL
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myjobmanagerbundle_devis';
    }


}
