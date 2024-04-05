<?php

namespace Formatz\Bundle\PhoneNumberBundle\Form;

use Formatz\Bundle\PhoneNumberBundle\Form\DataTransformer\PhoneNumberToStringTransformer;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Phone number form type.
 */
class PhoneNumberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addViewTransformer(
            new PhoneNumberToStringTransformer($options['default_region'], $options['format'])
        );
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['type'] = 'tel';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            array(
                'compound' => false,
                'default_region' => 'CH',
                'format' => PhoneNumberFormat::E164,
                'invalid_message' => 'This value is not a valid phone number.',
            )
        );
    }

    public function getParent(): ?string
    {
        return TextType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'app_bundle_phone_type';
    }
}
