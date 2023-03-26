<?php

namespace Zolat\AuthorityToLeave\Model\Quote;

use Magento\Quote\Api\Data\CartInterface;

interface SetAuthorityToLeaveInterface
{
    /**
     * Set the authority to leave status for a quote
     * @param CartInterface $quote
     * @param bool $authorityToLeave
     * @return void
     */
    public function execute(\Magento\Quote\Api\Data\CartInterface $quote, bool $authorityToLeave): void;
}
