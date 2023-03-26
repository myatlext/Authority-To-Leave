<?php

namespace Zolat\AuthorityToLeave\Model\Quote;

use Magento\Quote\Model\Quote;

class HasAuthorityToLeave implements HasAuthorityToLeaveInterface
{

    public function execute(\Magento\Quote\Api\Data\CartInterface $quote) : bool
    {
        return false;
    }

}
