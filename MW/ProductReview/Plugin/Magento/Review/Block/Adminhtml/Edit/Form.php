<?php

namespace MW\ProductReview\Plugin\Magento\Review\Block\Adminhtml\Edit;

// follow this: https://magento.stackexchange.com/questions/149513/add-email-field-to-review-form-magento-2/211726

class Form extends \Magento\Review\Block\Adminhtml\Edit\Form
{
    public function beforeSetForm(\Magento\Review\Block\Adminhtml\Edit\Form $object, $form) {

        $review = $object->_coreRegistry->registry('review_data');

        $fieldset = $form->addFieldset(
            'review_details_extra',
            ['legend' => __('Review Details Extra Data'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField(
            'age',
            'note',
            [
                'label' => __('Age'),
                'text' => $this->getLayout()->createBlock(
                    \MW\ProductReview\Block\Adminhtml\Edit\Age::class
                )->toHtml()
            ]
        );

        $fieldset->addField(
            'skin_type',
            'note',
            [
                'label' => __('Skin Type'),
                'text' => $this->getLayout()->createBlock(
                    \MW\ProductReview\Block\Adminhtml\Edit\SkinType::class
                )->toHtml()
            ]
        );

        $fieldset->addField(
            'skin_concern',
            'note',
            [
                'label' => __('Skin Concern'),
                'text' => $this->getLayout()->createBlock(
                    \MW\ProductReview\Block\Adminhtml\Edit\SkinConcern::class
                )->toHtml()
            ]
        );

        $fieldset->addField(
            'review-media',
            'note',
            [
                'label' => __('Review Media'),
                'text' => $this->getLayout()->createBlock(
                    \MW\ProductReview\Block\Adminhtml\Edit\Media::class
                )->toHtml()
            ]
        );

        $fieldset->addField(
            'deleted_media',
            'text',
            [
                'name' => 'deleted_media',
                'style' => 'visibility:hidden;'
            ]
        );



        $fieldset->addField(
            'vote',
            'note',
            [
                'label' => __('Vote'),
                'text' => $this->getLayout()->createBlock(
                    \MW\ProductReview\Block\Adminhtml\Edit\Vote::class
                )->toHtml()
            ]
        );

        $fieldset->addField(
            'report',
            'note',
            [
                'label' => __('Report'),
                'text' => $this->getLayout()->createBlock(
                    \MW\ProductReview\Block\Adminhtml\Edit\Report::class
                )->toHtml()
            ]
        );

        $form->setValues($review->getData());

        return [$form];
    }
}