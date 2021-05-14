<?php

namespace Worker\Cashier\Services;

use Stripe\Card as StripeCard;
use Stripe\Token as StripeToken;
use Stripe\Customer as StripeCustomer;
use Stripe\Subscription as StripeSubscription;
use Worker\Cashier\Cashier;
use Worker\Cashier\Interfaces\PaymentGatewayInterface;
use Carbon\Carbon;

class DirectPaymentGateway implements PaymentGatewayInterface
{
    public $payment_instruction;
    public $confirmation_message;

    public function __construct($payment_instruction, $confirmation_message)
    {
        $this->payment_instruction = $payment_instruction;
        $this->confirmation_message = $confirmation_message;

        \Carbon\Carbon::setToStringFormat('jS \o\f F');
    }

    /**
     * Get payment guiline message.
     *
     * @return Boolean
     */
    public function getPaymentInstruction()
    {
        if ($this->payment_instruction) {
            return $this->payment_instruction;
        } else {
            return trans('cashier::messages.direct.payment_instruction.demo');
        }
    }

    /**
     * Get payment guiline message.
     *
     * @return Boolean
     */
    public function getPaymentConfirmationMessage()
    {
        if ($this->confirmation_message) {
            return $this->confirmation_message;
        } else {
            return trans('cashier::messages.direct.confirmation_message.demo');
        }
    }

    /**
     * Gateway validate.
     *
     * @return void
     */
    public function validate()
    {
    }

    /**
     * Service does not support auto recurring.
     *
     * @return boolean
     */
    public function supportsAutoBilling()
    {
        return false;
    }

    /**
     * Get checkout url.
     *
     * @return string
     */
    public function getCheckoutUrl($invoice, $returnUrl='/')
    {
        return \Worker\Cashier\Cashier::lr_action("\Worker\Cashier\Controllers\DirectController@checkout", [
            'invoice_uid' => $invoice->uid,
            'return_url' => $returnUrl,
        ]);
    }

    /**
     * Get connect url.
     *
     * @return string
     */
    public function getConnectUrl($returnUrl='/')
    {
        return \Worker\Cashier\Cashier::lr_action("\Worker\Cashier\Controllers\DirectController@connect", [
            'return_url' => $returnUrl,
        ]);
    }
}