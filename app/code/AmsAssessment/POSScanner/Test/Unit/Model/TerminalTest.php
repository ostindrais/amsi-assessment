<?php
declare(strict_types=1);

namespace AmsAssessment\POSScanner\Test\Unit\Model;

require_once '../../../Model/Terminal.php';
require_once '../../../Model/Product.php';

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use AmsAssessment\POSScanner\Model\Terminal;
use AmsAssessment\POSScanner\Model\Product;

class TerminalTest extends TestCase
{
    /**
     * @var Terminal
     */
    protected $model;

    public function testSetPricingForSingleProduct()
    {
        $terminal = new Terminal();
        $product = new Product();
        $product->name = 'A';
        $product->unitPrice = 2;
        $terminal->setPricing($product);
        $ref = new \ReflectionProperty('AmsAssessment\POSScanner\Model\Terminal', 'products');
        $ref->setAccessible(true);
        $pricing = $ref->getValue($terminal);
        $this->assertEquals(array('A' => $product), $pricing);
    }

    public function testSetPricingForSameProductReplacesIt()
    {
        $terminal = new Terminal();
        $product = new Product();
        $product->name = 'A';
        $product->unitPrice = 2;
        $terminal->setPricing($product);
        $product->unitPrice = 7;
        $product->volumeQuantity = 3;
        $product->volumePrice = 18;
        $terminal->setPricing($product);
        $ref = new \ReflectionProperty('AmsAssessment\POSScanner\Model\Terminal', 'products');
        $ref->setAccessible(true);
        $pricing = $ref->getValue($terminal);
        $this->assertEquals(array('A' => $product), $pricing);
    }

    public function testSetPricingForMultipleProductsAtOnce()
    {
        $terminal = new Terminal();
        $aProduct = new Product();
        $aProduct->name = 'A';
        $aProduct->unitPrice = 2;
        $bProduct = new Product();
        $bProduct->name = 'B';
        $bProduct->unitPrice = 14;
        $bProduct->volumeQuantity = 3;
        $bProduct->volumePrice = 24;
        $products = array($aProduct, $bProduct);
        $terminal->setPricing($products);
        $ref = new \ReflectionProperty('AmsAssessment\POSScanner\Model\Terminal', 'products');
        $ref->setAccessible(true);
        $pricing = $ref->getValue($terminal);
        $expectedProducts = array('A' => $aProduct, 'B' => $bProduct);
        $this->assertEquals($expectedProducts, $pricing);
    }

    public function testScanTotalsContinually()
    {
        $terminal = new Terminal();
        $product = new Product();
        $product->name = 'A';
        $product->unitPrice = 2;
        $terminal->setPricing($product);
        $terminal->scan('A');
        $this->assertEquals(2, $terminal->total);
        $terminal->scan('A');
        $this->assertEquals(4, $terminal->total);
    }

    public function testScanMultipleProducts()
    {
        $terminal = new Terminal();
        $product = new Product();
        $product->name = 'A';
        $product->unitPrice = 2;
        $terminal->setPricing($product);
        $terminal->scan(array('A','A'));
        $this->assertEquals(4, $terminal->total);
    }

    private function setupTestCaseTerminal()
    {
        $terminal = new Terminal();
        $productA = new Product();
        $productA->name = 'A';
        $productA->unitPrice = 2;
        $productA->volumeQuantity = 4;
        $productA->volumePrice = 7;
        $terminal->setPricing($productA);
        $productB = new Product();
        $productB->name = 'B';
        $productB->unitPrice = 12;
        $terminal->setPricing($productB);
        $productC = new Product();
        $productC->name = 'C';
        $productC->unitPrice = 1.25;
        $productC->volumeQuantity = 6;
        $productC->volumePrice = 6;
        $terminal->setPricing($productC);
        $productD = new Product();
        $productD->name = 'D';
        $productD->unitPrice = 0.15;
        $terminal->setPricing($productD);
        return $terminal;
    }

    public function testCaseOne()
    {
        $terminal = $this->setupTestCaseTerminal();
        $terminal->scan(array('A','B','C','D','A','B','A','A'));
        $this->assertEquals(32.4, $terminal->total);
    }

    public function testCaseTwo()
    {
        $terminal = $this->setupTestCaseTerminal();
        $terminal->scan(array('C','C','C','C','C','C','C'));
        $this->assertEquals(7.25, $terminal->total);
    }

    public function testCaseThree()
    {
        $terminal = $this->setupTestCaseTerminal();
        $terminal->scan(array('A','B','C','D'));
        $this->assertEquals(15.4, $terminal->total);
    }
}
