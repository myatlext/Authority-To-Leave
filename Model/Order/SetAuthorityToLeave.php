<?php

namespace Zolat\AuthorityToLeave\Model\Order;

class SetAuthorityToLeave implements SetAuthorityToLeaveInterface
{
    public function execute(\Magento\Sales\Api\Data\OrderInterface $order, $authorityToLeave) : void
    {
        $order->setData('has_authority_to_leave', $authorityToLeave);
    }

}
