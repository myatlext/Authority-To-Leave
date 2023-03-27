<?php

namespace Zolat\AuthorityToLeave\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const XPATH_CONFIG_AUTHORITY_TO_LEAVE_ENABLED = 'sales/authority_to_leave/enabled';

    private ScopeConfigInterface $storeConfig;

    public function __construct(
        ScopeConfigInterface $storeConfig
    )
    {
        $this->storeConfig = $storeConfig;
    }

    /**
     * Is the authority to leave module enabled
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled(?int $storeId = null) : bool
    {
        return (bool) $this->storeConfig->getValue(self::XPATH_CONFIG_AUTHORITY_TO_LEAVE_ENABLED, ScopeInterface::SCOPE_STORE, $storeId);
    }

}
