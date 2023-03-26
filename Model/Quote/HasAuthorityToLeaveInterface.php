<?php

namespace Zolat\AuthorityToLeave\Model\Quote;

use Magento\Quote\Api\Data\CartInterface;

interface HasAuthorityToLeaveInterface
{
    /**
     * Get the authority to leave status for a quote
     * @param CartInterface $quote
     * @return bool
     */
    public function execute(\Magento\Quote\Api\Data\CartInterface $quote): bool;
}
