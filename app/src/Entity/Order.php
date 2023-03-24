<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: "`order`")]
class Order
{
    use TimestampableEntity;

    /**
     * An order that is in progress, not placed yet.
     *
     * @var string
     */
    public const STATUS_CART = 'cart';

    public const STATUS_NEW = 'new';

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $status;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "orders")]
    private User $user;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private int $items_total = 0;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private string $payment_url;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private \DateTimeInterface $paid_at;

    #[ORM\OneToMany(mappedBy: "orders", targetEntity: OrderItem::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private $orderItem;

    public function __construct(?string $status)
    {
        $this->orderItem = new ArrayCollection();
        $this->status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getItemsTotal(): ?int
    {
        return $this->items_total;
    }

    /**
     * @param int $items_total
     * @return $this
     */
    public function setItemsTotal(int $items_total): self
    {
        $this->items_total = count($this->getItems());
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentUrl(): ?string
    {
        return $this->payment_url;
    }

    public function setPaymentUrl(?string $payment_url): self
    {
        $this->payment_url = $payment_url;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paid_at;
    }

    public function setPaidAt(?\DateTimeInterface $paid_at): self
    {
        $this->paid_at = $paid_at;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getItems(): Collection
    {
        return $this->orderItem;
    }

    public function addItem(OrderItem $item): self
    {
        foreach ($this->getItems() as $existingItem) {
            if($existingItem->equals($item)) {
                $existingItem->setQuantity(
                    $existingItem->getQuantity() + $item->getQuantity()
                );
                return $this;
            }
        }

        $this->orderItem[] = $item;
        $item->setOrder($this);

        return $this;
    }

    public function removeItem(OrderItem $orderItem): self
    {
        if ($this->orderItem->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrder() === $this) {
                $orderItem->setOrder(null);
            }
        }

        return $this;
    }

    public function removeItems() : self
    {
        foreach ($this->getItems() as $item) {
            $this->removeItem($item);
        }
        return  $this;
    }

    public function getTotal() : float
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }
}
