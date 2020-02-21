<?php

namespace MW\ProductReview\Model\Options;

class SkinConcern implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            0 => __("Acne/Oiliness"),
            1 => __("Clogged Pores"),
            2 => __("Dehydration"),
            3 => __("FineLines/Wrinkles"),
            4 => __("Pigmentation/Spots"),
            5 => __("Sensitivity/Redness"),
            6 => __("Signs of Aging")
        ];
    }
}