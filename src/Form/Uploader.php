<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class Uploader extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('file',FileType::class,['attr'=>['class' => 'uploader'],
            'label' => 'Upload your file here: ',
            'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'text/csv',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid CSV or xlsx document',
                    ])
                
            ],
            'attr' => [
                'accept' => '.csv, .xlsx'
            ]])
            ->add('Convert',SubmitType::class,['attr' => ['class' => 'uploader--state-success']]);
    }
}
