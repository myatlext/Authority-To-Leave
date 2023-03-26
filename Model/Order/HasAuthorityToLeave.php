<?php

namespace Zolat\AuthorityToLeave\Model\Order;

class HasAuthorityToLeave implements HasAuthorityToLeaveInterface
{

    public function execute(\Magento\Sales\Api\Data\OrderInterface $order) : bool
    {
        return false;
    }

}
