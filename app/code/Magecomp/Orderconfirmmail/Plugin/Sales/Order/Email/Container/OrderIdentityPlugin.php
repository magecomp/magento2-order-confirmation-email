<?php
/**
 * Created by PhpStorm.
 * User: Bharat-Magecomp
 * Date: 8/29/2019
 * Time: 9:24 AM
 */

namespace Magecomp\Orderconfirmmail\Plugin\Sales\Order\Email\Container;


class OrderIdentityPlugin
{
    /**
     * @var \Magento\Checkout\Model\Session $checkoutSession
     */
    protected $checkoutSession;
    protected $helperData;

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     *
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magecomp\Orderconfirmmail\Helper\Data $helperData
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->helperData = $helperData;
    }

    /**
     * @param \Magento\Sales\Model\Order\Email\Container\OrderIdentity $subject
     * @param callable $proceed
     * @return bool
     */
    public function aroundIsEnabled(\Magento\Sales\Model\Order\Email\Container\OrderIdentity $subject, callable $proceed)
    {
        $returnValue = $proceed();
        if($this->helperData->isEnabled()) {
            $returnValue = false;
            $forceOrderMailSentOnSuccess = $this->checkoutSession->getForceOrderMailSentOnSuccess();
            if (isset($forceOrderMailSentOnSuccess) && $forceOrderMailSentOnSuccess) {
                $returnValue = true;
                $this->checkoutSession->unsForceOrderMailSentOnSuccess();
            }
        }
        return $returnValue;
    }
}