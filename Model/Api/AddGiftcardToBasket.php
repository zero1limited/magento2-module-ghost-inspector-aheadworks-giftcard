<?php
namespace Zero1\GhostInspectorAheadworksGiftcard\Model\Api;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Zero1\GhostInspectorAheadworksGiftcard\Api\AddGiftcardToBasketInterface;
use Aheadworks\Giftcard\Model\Product\Type\Giftcard;

class AddGiftcardToBasket implements AddGiftcardToBasketInterface
{
    /** @var ProductCollectionFactory */
    protected $productCollectionFactory;

    /** @var StockItemRepository */
    protected $stockItemRepository;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        StockItemRepository $stockItemRepository,
        ProductRepositoryInterface $productRepositoryInterface
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->stockItemRepository = $stockItemRepository;
        $this->productRepository = $productRepositoryInterface;
    }

    /**
     * @return \Zero1\GhostInspectorAheadworksGiftcard\Api\Data\AddGiftcardToBasket
     */
    public function getConfiguration()
    {
        $product = $this->findProduct();
        if(!$product){
            return new \Zero1\GhostInspectorAheadworksGiftcard\Api\Data\AddGiftcardToBasket(false);
        }
        return new \Zero1\GhostInspectorAheadworksGiftcard\Api\Data\AddGiftcardToBasket(
            true,
            $product->getSku(),
            $product->getId()
        );
    }

    /**
     * @return \Magento\Catalog\Model\Product|null
     */
    protected function findProduct()
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
        $productCollection->addAttributeToFilter('type_id', Giftcard::TYPE_CODE);
        $productCollection->addAttributeToFilter('visibility', 4);
        $productCollection->addAttributeToFilter('status', 1);
        $productCollection->addStoreFilter();

        /** @var \Magento\Catalog\Model\Product $product */
        foreach($productCollection->getItems() as $product){
            if($product->getTypeInstance()->isSalable($product)){
                return $product;
            }
        }
        return null;
    }
}
