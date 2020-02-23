<?php

namespace Command\Log\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    public $urlBuilder;

    public $layout;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        \Magento\Framework\View\LayoutInterface $layout,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->layout = $layout;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function getViewUrl()
    {
        return $this->urlBuilder->getUrl(
            $this->getData('config/viewUrlPath')
        );
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = $this->layout->createBlock(
                        \Magento\Backend\Block\Widget\Button::class,
                        '',
                        [
                            'data' => [
                                'label' => __('View'),
                                'type' => 'button',
                                'disabled' => false,
                                'class' => 'aureatelabs-grid-view',
                                'onclick' => 'aureatelabsView.open(\''. $this->getViewUrl().'\', \''.$item['id'].'\')',
                            ]
                        ]
                    )->toHtml();
                }
            }
        }

        return $dataSource;
    }
}
