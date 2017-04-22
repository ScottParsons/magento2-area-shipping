<?php
/*
 * Turiknox_AreaShipping

 * @category   Turiknox
 * @package    Turiknox_AreaShipping
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-area-shipping/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\AreaShipping\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Area implements ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'webapi_rest', 'label' => __('Frontend')],
            ['value' => 'adminhtml', 'label' => __('Backend')]
        ];
    }
}