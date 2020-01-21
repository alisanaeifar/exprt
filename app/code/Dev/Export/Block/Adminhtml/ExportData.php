<?php

namespace Dev\Export\Block\Adminhtml;

use Magento\Framework\View\Element\Template;

class ExportData extends \Magento\Framework\View\Element\Template
{
    protected $orderRepository;

    protected $searchCriteriaBuilder;

    protected $_orderCollectionFactory;

    protected $orders;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\Sales\Model\OrderRepository $orderRepository,
         \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->product = $product;
        $this->_orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getOrderById($id) {
        return $this->orderRepository->get($id);
    }

    public function getOrderByIncrementId($incrementId) {
        $this->searchCriteriaBuilder->addFilter('increment_id', $incrementId);

        $order = $this->orderRepository->getList(
            $this->searchCriteriaBuilder->create()
        )->getItems();

        return $order;
    }

    public function getProduct($id)
    {
        return $this->product->create()->load($id);
    }

    public function getOrders()
    {
        if (!$this->orders) {
            $this->orders = $this->_orderCollectionFactory->create()->addFieldToSelect('*');
        }
        return $this->orders;
    }
}
?>

