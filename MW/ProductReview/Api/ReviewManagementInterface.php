<?php


namespace MW\ProductReview\Api;


interface ReviewManagementInterface
{
    /**
     * GET for Post api
     * @api
     * @param string $param
     * @return string
     */
    public function getPost($param);
}