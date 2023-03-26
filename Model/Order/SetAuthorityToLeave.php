<?php

namespace Zolat\AuthorityToLeave\Model\Order;

class SetAuthorityToLeave implements SetAuthorityToLeaveInterface
{
    public function execute(\Magento\Sales\Api\Data\OrderInterface $order, $authorityToLeave) : void
    {
        return;
    }

}
