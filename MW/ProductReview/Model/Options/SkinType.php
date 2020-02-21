<?php


namespace MW\ProductReview\Model\Options;


class SkinType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            0 => __("Oily"),
            1 => __("Dry"),
            2 => __("Sensitive"),
            3 => __("Resistant"),
            4 => __("Pigmented"),
            5 => __("Non-Pigmented"),
            6 => __("Wrinkled"),
            7 => __("Tight")
        ];
    }
}