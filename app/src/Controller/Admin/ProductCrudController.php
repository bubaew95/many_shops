<?php

namespace App\Controller\Admin;

use App\Admin\Field\AttributeSelectField;
use App\Entity\Product;
use App\Form\ProductImagesType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->renderContentMaximized()
            ->addFormTheme(
                '@FOSCKEditor/Form/ckeditor_widget.html.twig'
            )//            ->overrideTemplate('crud/edit', 'bundles/EasyAdminBundle/custom/edit_product_page.html.twig')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $image          = ImageField::new('image')->setBasePath('/')->setUploadDir('/public/uploads');
        $id             = IdField::new('id');
        $name           = TextField::new('name');
        $alias          = SlugField::new('alias')->setTargetFieldName('name');
        $tags           = TextareaField::new('tags');
        $price          = TextField::new('price');
        $discount       = PercentField::new('discount')->setNumDecimals(2);
        $ratings        = TextField::new('ratings');
        $voite          = TextField::new('voite');
        $desciprtion    = TextareaField::new('description');
        $text           = TextareaField::new('text')->setFormType(CKEditorType::class)
            ->setFormTypeOptions([
                'config' => [
                    'toolbar'      => 'full',
                    'extraPlugins' => 'templates',
                    'rows'         => '50',
                ]
            ]);
        $characteristic = TextareaField::new('characteristic')->setFormType(CKEditorType::class);
        $shop           = AssociationField::new('shop')->setCrudController(ShopsCrudController::class);
        $category       = AssociationField::new('category');

        $images = CollectionField::new('productImages')->setFormTypeOptions([
            'entry_type' => ProductImagesType::class
        ]);

        if (Crud::PAGE_INDEX === $pageName) {
            return [
                $id,
                $image,
                $name,
                $desciprtion,
                $price
            ];
        }

        if (Crud::PAGE_EDIT === $pageName || Crud::PAGE_NEW === $pageName) {
            return [
                FormField::addTab('Общее')->setIcon('home'),
                FormField::addPanel('Общее')->setIcon('fa fa-reply')->setCssClass('col-sm-8 col-md-8'),

                $name->setColumns('col-md-12 col-xx-12'),
                $desciprtion->setColumns('col-md-12 col-xx-12'),
                $text->setColumns('col-md-12 col-xx-12'),
                $characteristic->setColumns('col-md-12 col-xx-12'),

                FormField::addPanel('Дополнительно')->setCssClass('col-sm-4 col-md-4'),

                $alias->setColumns('col-md-12 col-xx-12'),
                $price->setColumns('col-md-12 col-xx-12'),
                $discount->setColumns('col-md-12 col-xx-12'),
                $tags->setColumns('col-md-12 col-xx-12'),
                $image->setColumns('col-md-12 col-xx-12'),
                $shop->setColumns('col-md-12 col-xx-12'),
                $category->setColumns('col-md-12 col-xx-12'),
                $images->setColumns('col-md-12 col-xx-12'),
                FormField::addTab('Атрибуты')->setIcon('cogs')
            ];
        }

        return parent::configureFields($pageName);
    }
}
