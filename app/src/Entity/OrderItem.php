<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 50, nullable: true)]
    private string $status;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private string $price;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank()]
    #[Assert\GreaterThanOrEqual(1)]
    private int $quantity;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "orderItem")]
    private $orders;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: "orderItems")]
    private $product;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    private ?Shops $shop = null;

    /**
     * @param string $price
     * @param int $quantity
     * @param $product
     */
    public function __construct(Product $product, int $quantity, string $price)
    {
        $this->price        = $price;
        $this->quantity     = $quantity;
        $this->product      = $product;
        $this->shop         = $product->getShop();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->orders;
    }

    public function setOrder(?Order $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @param OrderItem $item
     * @return bool
     */
    public function equals(OrderItem $item) : bool
    {
        return $this->getProduct()->getId() === $item->getProduct()->getId();
    }

    public function getTotal() : float
    {
        return $this->getProduct()->getPrice() * $this->getQuantity();
    }

    public function getShop(): ?Shops
    {
        return $this->shop;
    }

    public function setShop(?Shops $shop): self
    {
        $this->shop = $shop;

        return $this;
    }
}
