<?php

namespace AmsAssessment\CartCSVDownload\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_FIELD = 'ams_assessment/downloads/';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    public function getFieldConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_FIELD . $code, $storeId);
    }
}
