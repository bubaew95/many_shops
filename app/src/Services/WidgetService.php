<?php

namespace App\Services;

use App\Entity\Shops;
use App\Entity\Widget;
use App\Interfaces\WidgetInterface;
use App\Repository\WidgetRepository;

class WidgetService
{
    public function __construct(
        private WidgetRepository $widgetRepository
    ) {
    }

    public function slider(int $limit = 3)
    {
        return $this->widgetRepository->loadWidgetsCriteria(5, $limit);
    }

    /**
     * Форматированный список виджетов
     *
     * @param Shops $shop
     * @return array|null
     */
    public function widgets(Shops $shop) : ?array
    {
        $widgets = $this->widgetRepository->findBy(['shop' => $shop]);
        return $this->createList($widgets);
    }

    /**
     * Форматирование виджетов
     *
     * @param array $widgets
     * @return array|null
     */
    private function createList(array $widgets) : ?array
    {
        if (!$widgets) {
            return null;
        }

        $list = [];
        /** @var Widget $widget */
        foreach ($widgets as $widget) {
            $list[WidgetInterface::WIDGETS[$widget->getBlock()]][] = $widget;
        }
        return $list;
    }

}