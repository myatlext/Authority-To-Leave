<?php

namespace Zolat\AuthorityToLeave\Model\Order;

use Magento\Sales\Api\Data\OrderInterface;

interface SetAuthorityToLeaveInterface
{
    /**
     * Set the authority to leave status for an order
     * @param OrderInterface $order
     * @param $authorityToLeave
     * @return void
     */
    public function execute(\Magento\Sales\Api\Data\OrderInterface $order, $authorityToLeave): void;
}
