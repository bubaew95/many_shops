<?php
namespace App\Menu;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Contracts\Cache\CacheInterface;

class MenuBuilders  implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var FactoryInterface $factory
     */
    private FactoryInterface $factory;

    /**
     * @var EntityManagerInterface $entityManager
     */
    private EntityManagerInterface $entityManager;
    private CacheInterface $cache;
    private LoggerInterface $logger;

    private $data = [];

    /**
     * Add any other dependency you need...
     */
    public function __construct(
        FactoryInterface $factory,
        EntityManagerInterface $entityManager,
        CacheInterface $cache,
        LoggerInterface $logger
    ) {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * Отрисовка меню
     * @param array $options
     * @return ItemInterface
     */
    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav');
        $menuTree = $this->getMenuTree();

        if(!$menuTree) {
            $this->emptyMenu($menu);
        }

        $this->tree($menuTree, $menu);

        dump($this->data);
        return $menu;
    }

    /**
     * Отрисовка дерева
     * @param $items
     * @param $menu
     * @return mixed
     */
    private function tree($items, $menu, $url = null): mixed
    {
        if(!$items) {
            return $menu;
        }

        foreach ($items as $item) {
            $menuItem = $this->factory->createItem("{$item['title']}_{$item['id']}", [
                'uri' => $item['alias'],
                'label' => $item['title']
            ]);
            $menuItem->setAttribute('class', 'nav-item');

            $menuItem->setLinkAttribute('class', 'nav-link');
            $this->data['data'][] = $item;

            if($item['__children']) {
                $menuItem->setAttribute('class', 'nav-item dropdown');
                if($item['lvl'] === 1) {
                    $menuItem->setAttribute('class', 'd-block');
                }

                $this->tree($item['__children'], $menuItem, $url);
            }


            $menu->addChild($menuItem);
        }
        return $menu;
    }

    /**
     * Если меню пустой
     * @param $menu
     * @return void
     */
    private function emptyMenu($menu): void
    {
        $main = $this->factory->createItem('Main', [
            'route' => "app_index",
            'label' => "Главная"
        ]);
        $menu->addChild($main);
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function getMenuTree(): array
    {
        $menuRepository = $this->entityManager->getRepository(Category::class);
        $menuTree = $menuRepository->childrenHierarchy();

        return $this->cache->get('menu', function () use($menuTree) {
            uasort ($menuTree, [$this, 'sorted']);
            return $menuTree;
        });
    }

    /**
     * @param $x
     * @param $y
     * @return bool
     */
    private function sorted($x, $y): bool
    {
        return $x['position'] > $y['position'];
    }

}
