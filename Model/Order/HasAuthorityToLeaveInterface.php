<?php

namespace Zolat\AuthorityToLeave\Model\Order;

use Magento\Sales\Api\Data\OrderInterface;

interface HasAuthorityToLeaveInterface
{
    /**
     * Get the authority to leave status for an order
     * @param OrderInterface $order
     * @return bool
     */
    public function execute(\Magento\Sales\Api\Data\OrderInterface $order): bool;
}
