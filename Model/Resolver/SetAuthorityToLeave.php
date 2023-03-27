<?php

namespace Zolat\AuthorityToLeave\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\QuoteGraphQl\Model\Cart\CheckCartCheckoutAllowance;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;
use Magento\QuoteGraphQl\Model\Cart\SetPaymentMethodOnCart as SetPaymentMethodOnCartModel;
use Zolat\AuthorityToLeave\Model\Config;
use Zolat\AuthorityToLeave\Model\Quote\SetAuthorityToLeaveInterface;

class SetAuthorityToLeave implements \Magento\Framework\GraphQl\Query\ResolverInterface
{
    private GetCartForUser $getCartForUser;
    private CheckCartCheckoutAllowance $checkCartCheckoutAllowance;
    private SetAuthorityToLeaveInterface $setAuthorityToLeave;
    private Config $config;

    /**
     * @param GetCartForUser $getCartForUser
     * @param CheckCartCheckoutAllowance $checkCartCheckoutAllowance
     */
    public function __construct(
        GetCartForUser $getCartForUser,
        CheckCartCheckoutAllowance $checkCartCheckoutAllowance,
        SetAuthorityToLeaveInterface $setAuthorityToLeave,
        Config $config
    ) {
        $this->getCartForUser = $getCartForUser;
        $this->checkCartCheckoutAllowance = $checkCartCheckoutAllowance;
        $this->setAuthorityToLeave = $setAuthorityToLeave;
        $this->config = $config;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null): array
    {
        $storeId = (int)$context->getExtensionAttributes()->getStore()->getId();
        if(!$this->config->isEnabled($storeId)) {
            throw new GraphQlAuthorizationException(__('Authority to leave is not enabled'));
        }

        if (empty($args['input']['cart_id'])) {
            throw new GraphQlInputException(__('Required parameter "cart_id" is missing.'));
        }
        $maskedCartId = $args['input']['cart_id'];

        if (!isset($args['input']['has_authority_to_leave'])) {
            throw new GraphQlInputException(__('Required parameter "has_authority_to_leave" is missing.'));
        }
        $hasAuthorityToLeave = (boolean) $args['input']['has_authority_to_leave'];

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
