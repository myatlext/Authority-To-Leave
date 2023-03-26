<?php

namespace Zolat\AuthorityToLeave\Model\Quote;

class SetAuthorityToLeave implements SetAuthorityToLeaveInterface
{

    private \Magento\Quote\Api\CartRepositoryInterface $cartRepository;

    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository
    )
    {
        $this->cartRepository = $cartRepository;
    }

    public function execute(\Magento\Quote\Api\Data\CartInterface $quote, bool $authorityToLeave) : void
    {
        $quote->setData('has_authority_to_leave', $authorityToLeave);
        $this->cartRepository->save($quote);
    }
}
