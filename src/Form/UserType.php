<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'First Name',
            ])
            ->add('last_name', null, [
                'label' => 'Last Name',
            ])
            ->add('email', null, [
                'label' => 'Email Address',
            ])
            ->add('phone', null, [
                'label' => 'Phone Number',
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Student' => 'ROLE_STUDENT',
                    'Teacher' => 'ROLE_TEACHER',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Role',
                'constraints' => [
                    new NotBlank(message: 'Please select a role.'),
                ],
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Password',
            ])
            ->add('avatarFile', VichImageType::class, [
                'label' => 'Profile Image (JPG/PNG)',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Delete?',
                'download_uri' => false,
                'imagine_pattern' => 'squared_thumbnail_small',
            ])
            ->add('departement', ChoiceType::class, [
                'choices' => [
                    'Informatique' => 'informatique',
                    'Telecommunication' => 'telecommunication',
                    'GC' => 'GC',
                ],
                'required' => false,
                'label' => 'Department',
            ])
            ->add('speciality', null, [
                'required' => false,
                'label' => 'Speciality',
            ])
            ->add('cvFile', VichFileType::class, [
                'label' => 'Curriculum Vitae (PDF, DOC)',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Delete?',
                'download_label' => 'vich_uploader.link.download',
            ])
            ->add('skills', null, [
                'required' => false,
                'label' => 'Skills',
            ])
            ->add('progression', null, [
                'required' => false,
                'label' => 'Progression',
            ]);

        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
            fn($roles) => $roles[0] ?? null,
            fn($role) => [$role]
        ));

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            /** @var User $user */
            $user = $event->getData();
            $form = $event->getForm();

            if ($form->has('roles') && $form->get('roles')->getData()) {
                $user->setRoles($form->get('roles')->getData());
            }
            if (in_array('ROLE_TEACHER', $user->getRoles())) {
                $user->setCv(null);
                $user->setSkills(null);
            }

            if (in_array('ROLE_STUDENT', $user->getRoles())) {
                $user->setDepartement(null);
                $user->setSpeciality(null);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();
                if ($data instanceof User) {
                    if (null === $data->getId()) {
                        return ['Default', 'creation']; 
                    }
                    if (in_array('ROLE_TEACHER', $data->getRoles())) {
                        return ['Default', 'teacher'];
                    }
                    if (in_array('ROLE_STUDENT', $data->getRoles())) {
                        return ['Default', 'student'];
                    }
                }
                return ['Default'];
            },

        ]);
    }
}