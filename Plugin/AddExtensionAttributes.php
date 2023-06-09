<?php

namespace Zolat\AuthorityToLeave\Plugin;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Zolat\AuthorityToLeave\Model\Config;
use Zolat\AuthorityToLeave\Model\Order\HasAuthorityToLeave;

class AddExtensionAttributes
{
    private OrderExtensionFactory $orderExtensionFactory;
    private HasAuthorityToLeave $hasAuthorityToLeave;
    private Config $config;

    /**
     * @param OrderExtensionFactory $orderExtensionFactory
     * @param HasAuthorityToLeave $hasAuthorityToLeave
     */
    public function __construct(
        OrderExtensionFactory $orderExtensionFactory,
        HasAuthorityToLeave $hasAuthorityToLeave,
        Config $config
    )
    {
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->hasAuthorityToLeave = $hasAuthorityToLeave;
        $this->config = $config;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $result
     * @param int $id
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $result, $id): OrderInterface
    {
        if($this->config->isEnabled()) {
            $this->setExtensionAttributes($result);
        }
        return $result;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $result
     * @param $id
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $result, $id): OrderSearchResultInterface
    {
        if($this->config->isEnabled()) {
            foreach ($result->getItems() as $order) {
                $this->setExtensionAttributes($order);
            }
        }
        return $result;
    }

    /**
     * @param OrderInterface $order
     * @return void
     */
    private function setExtensionAttributes(\Magento\Sales\Api\Data\OrderInterface $order) : void
    {
        $extensionAttributes = $order->getExtensionAttributes();
        $orderExtension = $extensionAttributes ?? $this->orderExtensionFactory->create();
        $orderExtension->setData('has_authority_to_leave', $this->hasAuthorityToLeave->execute($order));
        $order->setExtensionAttributes($orderExtension);
    }
}
