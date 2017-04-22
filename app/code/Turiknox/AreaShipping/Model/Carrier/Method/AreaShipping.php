<?php
namespace Turiknox\AreaShipping\Model\Carrier\Method;
/*
 * Turiknox_AreaShipping

 * @category   Turiknox
 * @package    Turiknox_AreaShipping
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-area-shipping/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

class AreaShipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'area_shipping';

	/**
	 * @var bool
	 */
	protected $_isFixed = true;

	/**
	 * @var \Magento\Shipping\Model\Rate\ResultFactory
	 */
	protected $rateResultFactory;

	/**
	 * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
	 */
	protected $rateMethodFactory;

	/**
	 * @var \Magento\Framework\App\State
	 */
	protected $appState;

    /**
     * AreaShipping constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param State $appState
     * @param array $data
     */
	public function __construct(
		ScopeConfigInterface $scopeConfig,
		ErrorFactory $rateErrorFactory,
		LoggerInterface $logger,
		ResultFactory $rateResultFactory,
		MethodFactory $rateMethodFactory,
		State $appState,
		array $data = []
    )
    {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->appState = $appState;
    }

	/**
	 * Checks if admin area
	 *
	 * @return bool
	 */
	protected function isAvailableForArea()
	{
        $area = $this->_scopeConfig->getValue('carriers/area_shipping/area', ScopeInterface::SCOPE_WEBSITE);
        if ($this->appState->getAreaCode() === $area) {
            return true;
		}
		return false;
	}

	/**
	 * Free Shipping rate collector
	 *
	 * @param RateRequest $request
	 * @return bool|\Magento\Shipping\Model\Rate\Result
	 */
	public function collectRates(RateRequest $request)
	{
        if (!$this->getConfigFlag('active') || !$this->isAvailableForArea()) {
            return false;
        }

		/** @var \Magento\Shipping\Model\Rate\Result $result */
		$result = $this->rateResultFactory->create();

		/** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
		$method = $this->rateMethodFactory->create();

		$method->setCarrier($this->_code);
		$method->setCarrierTitle($this->getConfigData('title'));

		$method->setMethod($this->_code);
		$method->setMethodTitle($this->getConfigData('name'));

		$method->setPrice($this->getConfigData('price'));
		$method->setCost($this->getConfigData('price'));

		$result->append($method);

		return $result;
	}

	/**
	 * @return array
	 */
	public function getAllowedMethods()
	{
        return [$this->_code => $this->getConfigData('name')];
	}
}