<?php
namespace App\Form;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Entity\Subcategory;
use App\Entity\Catalogue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddNewProductFormType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $item= $this->entityManager->getRepository(Catalogue::class);
        $product= $item->find($id);

        $repository = $this->entityManager->getRepository(Category::class);
        $categories = $repository->findAll();

        $repositoryb = $this->entityManager->getRepository(Subcategory::class);
        $subcategories = $repositoryb->findAll();

        $builder
            ->add('nom', TextareaType::class)
            ->add('description', TextareaType::class)
            ->add('prix', IntegerType::class)
            ->add('promo',IntegerType::class, [
                'required'=>false,
            ])
            ->add('stock', IntegerType::class)
            ->add('category', ChoiceType::class, [
                'choices' => $categories,
                'choice_label' => 'nom',
                'multiple' => false,
            ])
            ->add('subcategory', ChoiceType::class, [
                'choices' => $subcategories,
                'choice_label'=>'nom',
                'multiple' => false,
                'label' => 'subcategory_name',
                'required'=>false,
            ])
        ;
    }
} 
?>