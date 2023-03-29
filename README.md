# Authority To Leave (ATL)
This module adds support for setting the authority to leave (ATL) status of an order. A GraphQL mutation allows the ATL status to be set for a customer's cart and this status is reflected in the Orders REST API and the admin order grid. 

## Installation Instructions

1. Add this GitHub repository to the composer project file
2. Add the module to the project: `composer require zolat/module-authority-to-leave:dev-main`
3. Enable and install the module: `bin/magento setup:up` 

The module can be enabled or disabled at `Sales -> Authority to leave -> Enabled (Yes/No)`

### Compatibility

Tested under version 2.4.6 of Magento Open Source

## GraphQL 

A mutation setHasAuthorityToLeaveOnCart is added to allow the front-end application to set the ATL status on the cart:

E.g. Set Authority to leave
```
mutation {
  setHasAuthorityToLeaveOnCart(
    input: {
      cart_id: "<Cart UID>",
      has_authority_to_leave: true
    }
  ) {
    cart {
     has_authority_to_leave  
    }
  }
}
```

The current ATL status of the cart can be retrieved from the new Cart property `has_authority_to_leave`.

## Integration APIs

The `/orders` and `/orders/<order_id>` APIs provide the ATL status of submitted orders via the extension attribute `has_authority_to_leave`.

## Admin 

The ATL status of an order can be viewed from the admin grid under the `Authority to leave` column.


