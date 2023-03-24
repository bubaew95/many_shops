<?php

namespace App\Menu;

use App\Services\MenuService;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param FactoryInterface $factory
     * @param LoggerInterface $logger
     * @param MenuService $menuService
     */
    public function __construct(
        private FactoryInterface $factory,
        private LoggerInterface  $logger,
        private MenuService      $menuService
    ) {}

    /**
     * Отрисовка меню
     *
     * @param array $options
     *
     * @return ItemInterface
     */
    public function createMenu(array $options): ItemInterface
    {
        ['shop' => $shop] = $options;

        $menuTree = $shop ? $this->menuService->getMenuTreeForShop($shop) : $this->menuService->getMenuTree();
        $menu     = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav');
        $this->tree($menuTree, $menu);

        return $menu;
    }

    /**
     * Отрисовка дерева
     *
     * @param array $items
     * @param ItemInterface $menu
     * @param string|null $url
     *
     * @return ItemInterface
     */
    private function tree(array &$items, ItemInterface $menu, string $url = null): ItemInterface
    {
        if (!$items) {
            return $menu;
        }

        foreach ($items as $item) {
            $link = "{$url}/{$item['alias']}";

            $menuOptions['label'] = $item['title'];
            $menuOptions['uri']   = $link;

            $menuItem = $this->factory->createItem("{$item['title']}_{$item['id']}", $menuOptions);
            $menuItem->setAttribute('class', 'nav-item');
            $menuItem->setLinkAttribute('class', 'nav-link');
            $menuItem->setLabelAttribute('class', 'large-menu-title');
            $menuItem->setChildrenAttribute('class', 'dropdown-menu dropdown-large-menu');

            if (!empty($item['banner'])) {
                $menuItem->setAttributes(['image' => $item['banner']]);
            }

            if (!empty($item['__children'])) {
                $menuItem->setAttribute('class', 'nav-item dropdown');
                $this->tree($item['__children'], $menuItem, $link);
            }

            $menu->addChild($menuItem);
        }
        return $menu;
    }

    /**
     * Если меню пустой
     *
     * @param $menu
     *
     * @return void
     */
    private function emptyMenu($menu): void
    {
        $main = $this->factory->createItem('Main', [
            'route' => "app_index",
            'label' => "Главная",
        ]);
        $menu->addChild($main);
    }
}
