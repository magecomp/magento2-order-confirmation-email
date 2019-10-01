<?php

namespace Magecomp\Orderconfirmmail\Helper;

use Magento\Store\Model\ScopeInterface;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    // GENERAL Configuration
    const SMS_GENERAL_ENABLED = 'orderconfirmmail/general/enable';


    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
       )
    {
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    public function getStoreid()
    {
        return $this->_storeManager->getStore()->getId();
    }


    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::SMS_GENERAL_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreid());
    }


}