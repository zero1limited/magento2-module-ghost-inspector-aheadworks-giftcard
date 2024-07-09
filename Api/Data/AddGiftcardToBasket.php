<?php
namespace Zero1\GhostInspectorAheadworksGiftcard\Api\Data;

class AddGiftcardToBasket
{
    /** @var bool */
    protected $hasProduct;

    /** @var string|null */
    protected $sku;

    /** @var int|null */
    protected $id;

    public function __construct(
        bool $hasProduct,
        string $sku = null, 
        int $id = null
    ){
        $this->hasProduct = $hasProduct;
        $this->sku = $sku;
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function hasProduct()
    {
        return $this->hasProduct;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
