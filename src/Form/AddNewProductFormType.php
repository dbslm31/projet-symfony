<?php
namespace App\Form;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Entity\Subcategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddNewProductFormType extends AbstractType{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $repository = $this->entityManager->getRepository(Category::class);
        $categories = $repository->findAll();

        $repositoryb=$this->entityManager->getRepository(Subcategory::class);
        $subcategories=$repositoryb->findall();

        $builder
            ->add('nom', TextareaType::class)
            ->add('description', TextareaType::class)
            ->add('prix', IntegerType::class)
            ->add('category', ChoiceType::class, [
                'choices' => $categories,
                'multiple'=>false,
                //'choice_label' => 'nom',
            ])
            /*->add('subcategory', CheckboxType::class, [
                'class' => Subcategory::class,
                'choices'=>$subcategories,
                'multiple'=>false,
                'label' => 'subcategory_name'
            ])*/
            ;
    }
}
?>