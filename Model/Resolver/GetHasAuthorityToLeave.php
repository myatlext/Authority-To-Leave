<?php

namespace Zolat\AuthorityToLeave\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Quote\Model\Quote;
use Magento\QuoteGraphQl\Model\Cart\CheckCartCheckoutAllowance;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;
use Magento\QuoteGraphQl\Model\Cart\SetPaymentMethodOnCart as SetPaymentMethodOnCartModel;
use Zolat\AuthorityToLeave\Model\Quote\HasAuthorityToLeaveInterface;
use Zolat\AuthorityToLeave\Model\Quote\SetAuthorityToLeaveInterface;

class GetHasAuthorityToLeave implements \Magento\Framework\GraphQl\Query\ResolverInterface
{
    private HasAuthorityToLeaveInterface $hasAuthorityToLeave;

    /**
     * @param GetCartForUser $getCartForUser
     * @param CheckCartCheckoutAllowance $checkCartCheckoutAllowance
     */
    public function __construct(
        HasAuthorityToLeaveInterface $hasAuthorityToLeave
    ) {
        $this->hasAuthorityToLeave = $hasAuthorityToLeave;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null): bool
    {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }
        /** @var Quote $cart */
        $cart = $value['model'];

        return $this->hasAuthorityToLeave->execute($cart);
    }
}
