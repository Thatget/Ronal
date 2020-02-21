<?php


namespace MW\ProductReview\Model;


class ReviewManagement implements \MW\ProductReview\Api\ReviewManagementInterface
{
    /**
     * {@inheritdoc}
     */
    public function getPost($param)
    {
        return 'api GET return the $param ' . $param;
    }
}