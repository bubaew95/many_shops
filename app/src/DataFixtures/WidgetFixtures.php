<?php

namespace App\DataFixtures;

use App\Entity\Shops;
use App\Entity\User;
use App\Entity\Widget;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WidgetFixtures extends BaseFixtures
{
    private const WIDGETS = [
        1 => [
            [
                'title'     => 'FREE SHIPPING & RETURN',
                'sub_title' => 'Free shipping on all orders over $49',
                'icon'      => 'bx bx-taxi',
            ],
            [
                'title'     => 'MONEY BACK GUARANTEE',
                'sub_title' => '100% money back guarantee',
                'icon'      => 'bx bx-dollar-circle',
            ],
            [
                'title'     => 'ONLINE SUPPORT 24/7',
                'sub_title' => 'Awesome Support for 24/7 Days',
                'icon'      => 'bx bx-support',
            ],
        ],
        2 => [
            [
                'title'     => 'MENS\' WEAR',
                'sub_title' => 'STARTING AT $9',
                'image'     => 'assets/images/promo/01.png',
                'btn_link'  => 'SHOP NOW',
                'link'      => 'http://localhost:8080/',
            ],
            [
                'title'     => 'WOMENS\' WEAR',
                'sub_title' => 'STARTING AT $9',
                'image'     => 'assets/images/promo/02.png',
                'btn_link'  => 'SHOP NOW',
                'link'      => 'http://localhost:8080/',
            ],
            [
                'title'     => 'KIDS\' WEAR',
                'sub_title' => 'STARTING AT $9',
                'image'     => 'assets/images/promo/03.png',
                'btn_link'  => 'SHOP NOW',
                'link'      => 'http://localhost:8080/',
            ],
        ],
        3 => [
            [
                'title'       => 'Sunglasses Sale',
                'btn_link'    => 'SHOP BY GLASSES',
                'image'       => 'assets/images/promo/06.png',
                'description' => 'See all Sunglasses and get 10% off at all Sunglasses',
            ],
            [
                'title'       => 'Cosmetics Sales',
                'btn_link'    => 'SHOP BY GLASSES',
                'image'       => 'assets/images/promo/06.png',
                'description' => 'Buy Cosmetics products and get 30% off at all Cosmetics',
            ],
            [
                'title'       => 'Fashion Summer Sale',
                'sub_title'   => 'UP TO 80% OFF',
                'btn_link'    => 'SHOP BY GLASSES',
                'image'       => 'assets/images/promo/06.png',
                'description' => 'On top Fashion Brands',
            ],
            [
                'title'       => 'SUPER SALE',
                'sub_title'   => 'UP TO 50% OFF',
                'btn_link'    => 'SHOP BY GLASSES',
                'image'       => 'assets/images/promo/06.png',
                'description' => 'On All Electronic',
            ],
        ],
        4 => [
            [
                'title'       => 'FREE DELIVERY',
                'sub_title'   => 'Free Delivery Over $199',
                'icon'        => 'bx bx-cart',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec vestibulum magna, et dapib.',
            ],
            [
                'title'       => 'SECURE PAYMENT',
                'sub_title'   => 'We Possess SSL / Secure Сertificate',
                'icon'        => 'bx bx-credit-card',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec vestibulum magna, et dapib.',
            ],
            [
                'title'       => 'FREE RETURNS',
                'sub_title'   => 'We Return Money Within 30 Days',
                'icon'        => 'bx bx-dollar-circle',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec vestibulum magna, et dapib.',
            ],
            [
                'title'       => 'CUSTOMER SUPPORT',
                'sub_title'   => 'Friendly 24/7 Customer Support',
                'icon'        => 'bx bx-support',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec vestibulum magna, et dapib.',
            ],
        ],
        5 => [
            [
                'title'       => 'Huge Summer Collection',
                'sub_title' => 'Has just arrived!',
                'btn_link'    => 'Shop Now',
                'image'       => 'assets/images/slider/04.png',
                'description' => 'Swimwear, Tops, Shorts, Sunglasses & much more...',
            ],
            [
                'title'       => 'Women Sportswear Sale',
                'sub_title' => 'Hurry up! Limited time offer.',
                'btn_link'    => 'Shop Now',
                'image'       => 'assets/images/slider/05.png',
                'description' => 'Sneakers, Keds, Sweatshirts, Hoodies & much more...',
            ],
            [
                'title'       => 'New Men\'s Accessories',
                'sub_title' => 'Complete your look with',
                'btn_link'    => 'Shop Now',
                'image'       => 'assets/images/slider/03.png',
                'description' => 'Hats & Caps, Sunglasses, Bags & much more...',
            ],
        ]
    ];

    public function loadData(ObjectManager $manager): void
    {
        foreach (self::WIDGETS as $block => $widgetItem) {
            foreach ($widgetItem as $item) {
                $this->widgetElement($manager,  $block, $item);

//                for ($i = 0; $i < count($widgetItem); $i++) {
                for ($i = 0; $i < 1; $i++) {
                    $this->widgetElement($manager,  $block, $item, true);
                }
            }
        }


        /**
         * Добавление слайдера для магазинов
         */
        for ($i = 0; $i < 9; $i++) {
            $list = self::WIDGETS[5];
            for ($j = 0; $j < count($list); $j++){
                $widget = new Widget();
                $widget
                    ->setBlock(5)
                    ->setTitle($list[$j]['title'])
                    ->setSubTitle($list[$j]['sub_title'])
                    ->setBtnTitle($list[$j]['btn_link'])
                    ->setImage($list[$j]['image'])
                    ->setDescription($list[$j]['description'])
                    ->setShop(
                        $this->getRandomReference(Shops::class)
                    )
                ;

                if($this->faker->boolean()) {
                    $widget->setUser(
                        $this->getRandomReference(User::class)
                    );
                }

                $manager->persist($widget);
            }
        }

        $manager->flush();
    }

    private function widgetElement(ObjectManager $manager, int $block, array $item, bool $flag = false)
    {
        $widget = new Widget();
        $widget
            ->setTitle($item['title'])
            ->setBlock($block);

        if (array_key_exists('sub_title', $item)) {
            $widget->setSubTitle($item['sub_title']);
        }

        if (array_key_exists('icon', $item)) {
            $widget->setIcon($item['icon']);
        }

        if (array_key_exists('image', $item)) {
            $widget->setImage($item['image']);
        }

        if (array_key_exists('btn_link', $item)) {
            $widget->setBtnTitle($item['btn_link']);
        }

        if (array_key_exists('link', $item)) {
            $widget->setLink($item['link']);
        }

        if (array_key_exists('description', $item)) {
            $widget->setDescription($item['description']);
        }

        if($flag) {
            $widget->setShop(
                $this->getRandomReference(Shops::class)
            );
        }

        $manager->persist($widget);
    }
}
