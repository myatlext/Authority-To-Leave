<?php

namespace Zolat\AuthorityToLeave\Model\Quote;

class SetAuthorityToLeave implements SetAuthorityToLeaveInterface
{
    public function execute(\Magento\Quote\Api\Data\CartInterface $quote, bool $authorityToLeave) : void
    {
        return;
    }
}
