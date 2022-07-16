<?php

namespace AmsAssessment\POSScanner\Model;

class Terminal
{
    private $products = array();
    private $cart = array();
    public $total;

    public function setPricing($product)
    {
        if (is_array($product)) {
            foreach ($product as $productObject) {
                $this->setPricing($productObject);
            }
        } else if (is_a($product, 'AmsAssessment\POSScanner\Model\Product')) {
            $this->products[$product->name] = $product;
        }
    }

    public function scan($productName)
    {
        if (is_array($productName)) {
            foreach ($productName as $scanProduct) {
                $this->scan($scanProduct);
            }
            return;
        }
        if (!isset($this->cart[$productName])) {
            $this->cart[$productName] = 0;
        }
        $this->cart[$productName]++;
        $this->calculateTotal();
    }

    private function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->cart as $productName => $count) {
            $thisProduct = $this->products[$productName];
            if ($thisProduct->volumeQuantity > 0 && $count >= $thisProduct->volumeQuantity) {
                $numberOfVolumes = floor($count / $thisProduct->volumeQuantity);
                $remainder = $count % $thisProduct->volumeQuantity;
                $this->total += $numberOfVolumes * $thisProduct->volumePrice;
                $this->total += $remainder * $thisProduct->unitPrice;
                continue;
            }
            $this->total += $count * $thisProduct->unitPrice;
        }
    }
}
