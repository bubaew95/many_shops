<?php

namespace App\Controller\Admin;

use App\Entity\Pages;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class PagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pages::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['title', 'description'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(10)
            ->setNumberFormat('%.2d')
            ->setDateIntervalFormat('%%y Year(s) %%m Month(s) %%d Day(s)')
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setEntityLabelInPlural('Страницы')
            ->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        $id          = IdField::new('id');
        $title       = TextField::new('title');
        $description = TextareaField::new('description');
        $createdAt   = DateTimeField::new('createdAt')->onlyOnDetail();
        $text        = TextEditorField::new('text');
        $tags        = TextField::new('tags');
        $alias       = SlugField::new('alias')->setTargetFieldName('title');
        $link        = TextField::new('link');
        $status      = ChoiceField::new('status')->setChoices([
            "Опубликовать"    => 'publish',
            "Не опубликовать" => 'unpublish'
        ]);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $description, $createdAt, $status];
        }

        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_NEW) {
            return [$title, $alias, $link, $description, $text, $tags, $status];
        }

        return array_merge(parent::configureFields($pageName), [
            TextEditorField::new('text'),
        ]);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add(ChoiceFilter::new('status')->setChoices([
                "Опубликовать"    => 'publish',
                "Не опубликовать" => 'unpublish'
            ]))
            ->add('tags')
        ;
    }
}
