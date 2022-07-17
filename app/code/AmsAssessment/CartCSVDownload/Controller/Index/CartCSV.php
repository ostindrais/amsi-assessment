<?php
/**
 * Base code copied from: https://www.rakeshjesadiya.com/get-shopping-cart-all-items-magento-2/
 */
namespace AmsAssessment\CartCSVDownload\Controller\Index;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;

class CartCSV extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    /**
     * @var \AmsAssessment\CartCSVDownload\Helper\Data
     */
    protected $dataHelper;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;

    /**
     * @param \Magento\Framework\App\Action\Context            $context
     * @param \AmsAssessment\CartCSVDownload\Helper\Data       $dataHelper
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\File\Csv                      $csvProcessor
     * @param \Magento\Framework\App\Filesystem\DirectoryList  $directoryList
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \AmsAssessment\CartCSVDownload\Helper\Data $dataHelper,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        $this->fileFactory = $fileFactory;
        $this->dataHelper = $dataHelper;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        parent::__construct($context);
    }

    /**
     * CSV Create and Download
     *
     * @return ResponseInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        $csvDownloadEnabled = $this->dataHelper->getFieldConfig('csv_download_enabled');
        if (!$csvDownloadEnabled) {
            return;
        }

        // CSV header
        $content[] = [
            'productID' => __('Product ID'),
            'name' => __('Name'),
            'sku' => __('SKU'),
            'quantity' => __('Quantity'),
            'price' => __('Price'),
            'productType' => __('Product Type'),
            'discount' => __('Discount')
        ];

        $om =   \Magento\Framework\App\ObjectManager::getInstance();
        $cartData = $om->create('Magento\Checkout\Model\Cart')->getQuote()->getAllVisibleItems();

        foreach ($cartData as $cartItem) {
            $content[] = [
                $cartItem->getProductId(),
                $cartItem->getName(),
                $cartItem->getSku(),
                $cartItem->getQty(),
                $cartItem->getPrice(),
                $cartItem->getProductType(),
                $cartItem->getDiscountAmount()
            ];
        }
        $fileName = 'currentShoppingCart.csv'; // Add Your CSV File name
        $filePath =  $this->directoryList->getPath(DirectoryList::MEDIA) . "/" . $fileName;
        $this->csvProcessor->setEnclosure('"')->setDelimiter(',')->saveData($filePath, $content);
        return $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename",
                'value' => $fileName,
                'rm'    => true, // True => File will be removed from directory after download.
            ],
            DirectoryList::MEDIA,
            'text/csv',
            null
        );
    }
}
