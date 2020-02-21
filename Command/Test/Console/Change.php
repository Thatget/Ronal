<?php
namespace Command\Test\Console;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Change extends Command
{
    const ID = 'name';
    const QY = 'quantity';
    const CO = 'code';
    protected $sourceItemsSave;
    protected $sourceItemFactory;
    protected $product;
    protected $inventoryCollection;
    protected $testFactory;
    protected $_time;
    protected $_data;
    protected $eventManager;

    public function __construct(
        String $name= null,
        ProductRepository $product,
        \Magento\InventoryApi\Api\SourceItemsSaveInterface $sourceItemsSave,
        \Magento\InventoryApi\Api\Data\SourceItemInterfaceFactory $sourceItemFactory,
        \Magento\Inventory\Model\ResourceModel\Source\Collection $inventoryCollection,
        \Command\Test\Model\TestFactory $testFactory,
        DateTime $time,
        \Magento\Framework\Json\Helper\Data $data,
        \Magento\Framework\Event\ManagerInterface $manager
    ) {
        $this->product = $product;
        $this->sourceItemsSave = $sourceItemsSave;
        $this->sourceItemFactory = $sourceItemFactory;
        $this->inventoryCollection = $inventoryCollection;
        $this->testFactory = $testFactory;
        $this->_time = $time;
        $this->_data = $data;
        $this->eventManager = $manager;
        parent::__construct($name);
    }


    protected function configure()
    {
        $options = [
            new InputOption(
                self::ID,
                '-d',
                InputOption::VALUE_REQUIRED,
                'id'
            ),
            new InputOption(
                self::QY,
                '-t',
                InputOption::VALUE_REQUIRED,
                'Quantity'
            ),
            new InputOption(
                self::CO,
                '-c',
                InputOption::VALUE_REQUIRED,
                'code'
            )
        ];
        $this->setDescription('This is my first console command.');
        $this->setDefinition($options);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventManager->dispatch('my_module_event_before', ['condition' => true,'value' =>12]);
        $this_time = $this->_time->gmtDate();
        $data['time'] = $this_time;
        $i=0;
        $lack = '';
        if ($id1 = $input->getOption(self::ID)){
            if (is_numeric($id1)) {
                $id = (int)$id1;
                $data['input']['productId'] = $id;
            }else{
                $i++;
                $lack = 'product ID Khong dung dinh dang ';
                $data0['output1'] = $lack;
            }
        }else {
            $lack1 = 'Thieu product ID';
            $lack=$lack1;
            $data0['output1'] = $lack1;
        }
        if ($qy2 = $input->getOption(self::QY)){
            if (is_numeric($qy2)) {
                $qy = (float)$qy2;
                if ($qy<0){
                    $i++;
                    $lack2 = 'So luong sp khong dc am';
                    ($i==1)?($lack = $lack2):($lack = $lack.'/'.$lack2);
                    $data0['output2'] = $lack2;
                }else
                $data['input']['productQuantity'] = $qy2;
            }else{
                $i++;
                $lack2 = 'So luong sp khong dung dinh dang';
                ($i==1)?($lack = $lack2):($lack = $lack.'/'.$lack2);
                $data0['output2'] = $lack2;
            }
        }else{
            $i++;
            $lack3 = 'Khong Ghi so luong sl';
            ($lack==1)?($lack = $lack3):($lack = $lack.'/'.$lack3);
            $data0['output2'] = $lack3;
        }
        if ($co = $input->getOption(self::CO)){
            $data['input']['InventoryName'] = $co;
        }else {
            ($lack==1)?($lack = 'Thieu Inventory'):($lack = $lack.'/Thieu Inventory');
            $data0['output3'] = $lack;
            $i++;
        }
        $in = $this->_data->jsonEncode($data);
        $this->eventManager->dispatch('my_module_event_before', ['condition' => false,'value' =>111]);
        die('Quyet');
        if ($i!=0){
            $out = $this->_data->jsonEncode($data0);
            $this->setIntoTable($in,$out);
            $output->writeln($lack);
            return $this;
        }
            if (is_numeric($id1)&&is_numeric($qy2)){
                $id=(int)$id1;
                $qy=(float)$qy2;
                try {
                    $product = $this->product->getById($id);
                    $sku = $product->getSku();
                    $lap = $this->inventoryCollection->load();
                    $flag = true;
                    foreach ($lap as $item){
                        if($co == $item->getName()){
                            $set = $this->sourceItemFactory->create();
                            $set->setSku($sku);
                            $set->setQuantity($qy);
                            $set->setStatus(1);
                            $set->setSourceCode($item->getId());
                            $this->sourceItemsSave->execute([$set]);
                            $flag = false;
                            $out = ' Sua thanh cong !';
                            $output->writeln($out);
                            $this->setIntoTable($in,$out);
                            return $this;
                        }
                    }
                    if ($flag){
                        $out = ' Khong ton tai Source Name nay !';
                        $output->writeln($out);
                        $this->setIntoTable($in,$out);
                        return $this;
                    }

                }catch (\Exception $exception){
                    $out = ' Khong ton tai Id nay !';
                    $output->writeln($out);
                    return $this;
                }
            }

    }

    protected function setIntoTable($input,$output)
    {
        $in = $this->testFactory->create();
        $data = [
            'input'=>$input,
            'output'=>$output
        ];
        $in->setData($data);
        $in->save();
    }
}
