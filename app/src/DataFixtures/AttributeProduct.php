<?php

namespace App\DataFixtures;

use App\Entity\AttributeType;
use App\Entity\AttributeValue;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;

class AttributeProduct extends BaseFixtures
{
    private const ATTRIBUTES = [
        'Память' => [
            '128 ГБ', '256 ГБ', '512 ГБ', '1 ТБ'
        ],
        'Цвет' => [
            'Черный', 'Белый', 'Серый', 'Золотой', 'Фиолетовый', 'Синий'
        ],
        'Версия' => [
            "11", "12", "13", "14"
        ]
    ];

    /**
     * @throws \Exception
     */
    public function loadData(ObjectManager $manager): void
    {
        foreach (self::ATTRIBUTES as $key => $attributes) {
            $attributeType = new AttributeType();
            $attributeType->setName($key);

            foreach ($attributes as $attribute) {
                $attributeValue = new AttributeValue();
                $attributeValue->setValue($attribute);
                $attributeValue->setAttributeType($attributeType);
                $attributeValue->setProduct(
                    $this->getRandomReference(Product::class)
                );
                $manager->persist($attributeValue);
            }
            $manager->persist($attributeType);
        }
        $manager->flush();
    }
}
