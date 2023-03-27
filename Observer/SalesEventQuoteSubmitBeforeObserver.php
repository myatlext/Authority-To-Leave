<?php

namespace Zolat\AuthorityToLeave\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Zolat\AuthorityToLeave\Model\Order\SetAuthorityToLeaveInterface;
use Zolat\AuthorityToLeave\Model\Quote\HasAuthorityToLeaveInterface;

class SalesEventQuoteSubmitBeforeObserver implements ObserverInterface
{
    private HasAuthorityToLeaveInterface $quoteHasAuthorityToLeave;
    private SetAuthorityToLeaveInterface $orderSetAuthorityToLeave;

    public function __construct(
        HasAuthorityToLeaveInterface $quoteHasAuthorityToLeave,
        SetAuthorityToLeaveInterface $orderSetAuthorityToLeave
    )
    {
        $this->quoteHasAuthorityToLeave = $quoteHasAuthorityToLeave;
        $this->orderSetAuthorityToLeave = $orderSetAuthorityToLeave;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer) : void
    {
        $quote = $observer->getEvent()->getQuote();
        $order = $observer->getEvent()->getOrder();

        $this->orderSetAuthorityToLeave->execute($order, $this->quoteHasAuthorityToLeave->execute($quote));
    }
}
