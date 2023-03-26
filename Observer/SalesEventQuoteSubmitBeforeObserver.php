<?php

namespace Zolat\AuthorityToLeave\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SalesEventQuoteSubmitBeforeObserver implements ObserverInterface
{
    private \Zolat\AuthorityToLeave\Model\Quote\HasAuthorityToLeaveInterface $quoteHasAuthorityToLeave;
    private \Zolat\AuthorityToLeave\Model\Order\SetAuthorityToLeaveInterface $orderSetAuthorityToLeave;

    public function __construct(
        \Zolat\AuthorityToLeave\Model\Quote\HasAuthorityToLeaveInterface $quoteHasAuthorityToLeave,
        \Zolat\AuthorityToLeave\Model\Order\SetAuthorityToLeaveInterface $orderSetAuthorityToLeave
    )
    {
        $this->quoteHasAuthorityToLeave = $quoteHasAuthorityToLeave;
        $this->orderSetAuthorityToLeave = $orderSetAuthorityToLeave;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer) : void
    {
        $quote = $observer->getEvent()->getQuote();
        $order = $observer->getEvent()->getOrder();

        $this->orderSetAuthorityToLeave->execute($order, $this->quoteHasAuthorityToLeave->execute($quote));
    }
}
