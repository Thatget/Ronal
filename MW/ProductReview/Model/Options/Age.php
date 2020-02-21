<?php


namespace MW\ProductReview\Model\Options;


class Age implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            0 => __("18-24"),
            1 => __("25-34"),
            2 => __("35-44"),
            3 => __("45-54"),
            4 => __("55-64"),
            5 => __("65-74"),
            6 => __("75-90")
        ];
    }
}