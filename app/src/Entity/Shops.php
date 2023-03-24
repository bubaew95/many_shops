<?php

namespace App\Entity;

use App\Repository\ShopsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: ShopsRepository::class)]
class Shops
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[Gedmo\Slug(fields: ['name'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $alias;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $Tags;

    #[ORM\Column(type: 'text')]
    private $text;

    #[ORM\Column(type: 'string', length: 255)]
    private $logo;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $visit;

    #[ORM\Column(type: 'float', nullable: true)]
    private $ratings;

    #[ORM\Column(type: 'string', length: 25)]
    private $status;

    #[ORM\Column(type: 'json', nullable: true)]
    private $settings = [];

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: Product::class)]
    private $products;

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: ShopCategories::class)]
    private $shopCategories;

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: News::class)]
    private $blogs;

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: Widget::class)]
    private $sliders;

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: Pages::class)]
    private Collection $pages;

    #[ORM\OneToMany(mappedBy: 'shop', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->shopCategories = new ArrayCollection();
        $this->blogs = new ArrayCollection();
        $this->sliders = new ArrayCollection();
        $this->pages = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->Tags;
    }

    public function setTags(string $Tags): self
    {
        $this->Tags = $Tags;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getVisit(): ?int
    {
        return $this->visit;
    }

    public function setVisit(?int $visit): self
    {
        $this->visit = $visit;

        return $this;
    }

    public function getRatings(): ?float
    {
        return $this->ratings;
    }

    public function setRatings(?float $ratings): self
    {
        $this->ratings = $ratings;

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

    public function getSettings(): ?array
    {
        return $this->settings;
    }

    public function setSettings(?array $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setShop($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getShop() === $this) {
                $product->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ShopCategories>
     */
    public function getShopCategories(): Collection
    {
        return $this->shopCategories;
    }

    public function addShopCategory(ShopCategories $shopCategory): self
    {
        if (!$this->shopCategories->contains($shopCategory)) {
            $this->shopCategories[] = $shopCategory;
            $shopCategory->setShop($this);
        }

        return $this;
    }

    public function removeShopCategory(ShopCategories $shopCategory): self
    {
        if ($this->shopCategories->removeElement($shopCategory)) {
            // set the owning side to null (unless already changed)
            if ($shopCategory->getShop() === $this) {
                $shopCategory->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, News>
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(News $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->setShop($this);
        }

        return $this;
    }

    public function removeBlog(News $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getShop() === $this) {
                $blog->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Widget>
     */
    public function getSliders(): Collection
    {
        return $this->sliders;
    }

    public function addSlider(Widget $slider): self
    {
        if (!$this->sliders->contains($slider)) {
            $this->sliders[] = $slider;
            $slider->setShop($this);
        }

        return $this;
    }

    public function removeSlider(Widget $slider): self
    {
        if ($this->sliders->removeElement($slider)) {
            // set the owning side to null (unless already changed)
            if ($slider->getShop() === $this) {
                $slider->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pages>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Pages $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setShop($this);
        }

        return $this;
    }

    public function removePage(Pages $page): self
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getShop() === $this) {
                $page->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setShop($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getShop() === $this) {
                $orderItem->setShop(null);
            }
        }

        return $this;
    }
}
