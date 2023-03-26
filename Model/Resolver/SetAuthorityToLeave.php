<?php

namespace Zolat\AuthorityToLeave\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\QuoteGraphQl\Model\Cart\CheckCartCheckoutAllowance;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;
use Magento\QuoteGraphQl\Model\Cart\SetPaymentMethodOnCart as SetPaymentMethodOnCartModel;
use Zolat\AuthorityToLeave\Model\Quote\SetAuthorityToLeaveInterface;

class SetAuthorityToLeave implements \Magento\Framework\GraphQl\Query\ResolverInterface
{

    private GetCartForUser $getCartForUser;
    private CheckCartCheckoutAllowance $checkCartCheckoutAllowance;
    private SetAuthorityToLeaveInterface $setAuthorityToLeave;

    /**
     * @param GetCartForUser $getCartForUser
     * @param CheckCartCheckoutAllowance $checkCartCheckoutAllowance
     */
    public function __construct(
        GetCartForUser $getCartForUser,
        CheckCartCheckoutAllowance $checkCartCheckoutAllowance,
        SetAuthorityToLeaveInterface $setAuthorityToLeave
    ) {
        $this->getCartForUser = $getCartForUser;
        $this->checkCartCheckoutAllowance = $checkCartCheckoutAllowance;
        $this->setAuthorityToLeave = $setAuthorityToLeave;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null): array
    {
        if (empty($args['input']['cart_id'])) {
            throw new GraphQlInputException(__('Required parameter "cart_id" is missing.'));
        }
        $maskedCartId = $args['input']['cart_id'];

        if (!isset($args['input']['has_authority_to_leave'])) {
            throw new GraphQlInputException(__('Required parameter "has_authority_to_leave" is missing.'));
        }
        $hasAuthorityToLeave = (boolean) $args['input']['has_authority_to_leave'];

        $storeId = (int)$context->getExtensionAttributes()->getStore()->getId();
        $cart = $this->getCartForUser->execute($maskedCartId, $context->getUserId(), $storeId);
        $this->checkCartCheckoutAllowance->execute($cart);
        $this->setAuthorityToLeave->execute($cart, $hasAuthorityToLeave);

        return [
            'cart' => [
                'model' => $cart,
            ],
        ];
    }
}
