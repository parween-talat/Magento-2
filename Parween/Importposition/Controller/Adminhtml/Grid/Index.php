<?php
namespace Parween\Importposition\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * 
 * This controller is responsible for rendering the eBay Order List page in the admin panel.
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Constructor
     *
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute the controller action to render the page
     *
     * This action will be triggered when navigating to the Import Position grid page.
     * It prepares the result page and sets the page title.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        // Set the page title
        $resultPage->getConfig()->getTitle()->prepend(__('Import Position'));

        return $resultPage;
    }

    /**
     * Check if the user has permission to access the Order Import page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        // Define the ACL (Access Control List) rule that controls access to this controller action
        return $this->_authorization->isAllowed('Parween_Importposition::grid_index');
    }
}
