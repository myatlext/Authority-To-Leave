<?php

namespace Zolat\AuthorityToLeave\Model\Order;

class HasAuthorityToLeave implements HasAuthorityToLeaveInterface
{

    public function execute(\Magento\Sales\Api\Data\OrderInterface $order) : bool
    {
        return (bool) $order->getData('has_authority_to_leave');
    }

}
