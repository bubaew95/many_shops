<?php

namespace App\Services;

use App\Repository\CategoryRepository;

class MenuService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }

    /**
     * @param  string  $shop
     *
     * @return array|null
     */
    public function getMenuTreeForShop(string $shop): ?array
    {
        return $this->uasortBuildTree(
            $this->categoryRepository->getTreeCategoriesForShop($shop)
        );
    }

    /**
     * @return array|null
     */
    public function getMenuTree(): ?array
    {
        return $this->uasortBuildTree(
            $this->categoryRepository->getTreeCategories()
        );
    }

    /**
     * Массив категорий
     *
     * @param  array  $tree
     *
     * @return array|null
     */
    private function uasortBuildTree(array $tree): ?array
    {
        $categoryArray = $this->categoryRepository->buildTree(
            $tree,
            ['decorate' => false]
        );

        uasort($categoryArray, [$this, 'sorted']);
        return $categoryArray;
    }

    /**
     * @param $x
     * @param $y
     *
     * @return bool
     */
    private function sorted($x, $y): bool
    {
        return $x['position'] > $y['position'];
    }
}