<?php
namespace MW\Indeed\Console;


use Magento\CatalogInventory\Model\StockRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Sayhello extends Command
{
    const ID = 'id';
    const QTY = 'qty';
    const STOCKNAME = 'stockname';
    protected $_product;
    protected $_stockRegistry;
    protected $_inventoryCollection;
    protected $sourceItemFactory;
    protected $sourceItemsSave;


    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        StockRegistry $stockRegistry,
        \Magento\InventoryApi\Api\SourceItemsSaveInterface $sourceItemsSave,
        \Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory $sourceItemFactory,
        \Magento\Inventory\Model\ResourceModel\Source\Collection $inventoryCollection
    )
    {
        $this->sourceItemsSave = $sourceItemsSave;
        $this->sourceItemFactory = $sourceItemFactory;
        $this->_inventoryCollection = $inventoryCollection;
        $this->_stockRegistry = $stockRegistry;
        $this->_product = $productRepository;
        parent::__construct();
    }

    protected function configure()
    {

        $options= [
            new InputOption(self::ID, // the option name
                '-a', // the shortcut
                InputOption::VALUE_REQUIRED, // the option mode
                'Description for name parameter' // the description
            ),
            new InputOption(
                self::STOCKNAME,
                '-b',
                InputOption::VALUE_REQUIRED, // the option mode
                'Description for name parameter' // the description
            ),
            new InputOption(
                self::QTY,
                '-c',
                InputOption::VALUE_REQUIRED, // the option mode
                'Description for name parameter' // the description
            )
        ];

        $this->setName('example:sayhello')
            ->setDescription('Demo command line')
            ->setDefinition($options);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (($id1 = $input->getOption('id'))&&($qty1 = $input->getOption('qty'))&&($stockName = $input->getOption('stockname'))) {
            $id=(int)$id1;
            $qty = (float)$qty1;
            if (!is_numeric($qty)) {
                $output->writeln("So luong phai la kieu so !");
                return $this;
            }
            if ($qty <= 0) {
                $qty = 0;
            }
            try {

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
                die($StockState->getStockQty($id, $stockName));
                $in = $this->_inventoryCollection->load();
                $flag = false;
                foreach ($in as & $sourceItemName) {
                    if ($stockName == $sourceItemName->getId()) {
                        $flag = true;
                        $product = $this->_product->getById($id);
                        $productset = $product->getExtensionAttributes()->getStockItem()->s;
                        $productset->setQty($qty);
                        $productset->setIsInStock(1);
                        $productset->setStockId($stockName);
                        //$productset->save();
                        $this->_product->save($productset);
                        break;
                    }
                }
                if (!$flag) {
                    $output->writeln('This Inventory name ' . $stockName . ' doese exit !');
                    return $this;
                }
            } catch (\Exception $e) {
                $output->writeln('This ID ' . $id . 'is not exits !');
            }

        } else {
            $output->writeln("Thieu thong tin");
        }
        $output->writeln("Hello World");
        return $this;

    }
}