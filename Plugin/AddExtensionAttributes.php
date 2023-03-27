<?php

namespace Zolat\AuthorityToLeave\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class AddExtensionAttributes
{
    private OrderExtensionFactory $orderExtensionFactory;

    public function __construct(
        OrderExtensionFactory $orderExtensionFactory
    )
    {
        $this->orderExtensionFactory = $orderExtensionFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $result
     * @param int $id
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $result, $id): OrderInterface
    {
        $this->setExtensionAttributes($result);
        return $result;
    }

    private function setExtensionAttributes(\Magento\Sales\Api\Data\OrderInterface $order) : void
    {
        $extensionAttributes = $order->getExtensionAttributes();
        $orderExtension = $extensionAttributes ?? $this->orderExtensionFactory->create();
        $orderExtension->setData('has_authority_to_leave', (boolean) $order->getData('has_authority_to_leave'));
        $order->setExtensionAttributes($orderExtension);
    }
}
