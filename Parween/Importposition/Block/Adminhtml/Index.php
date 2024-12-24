<?php
namespace Parween\Importposition\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\UrlInterface;

/**
 * Class Index
 *
 * This class handles rendering of the form's action URL in the admin interface.
 * It extends the Template block class to render a custom admin page for the module.
 */
class Index extends Template
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Constructor method.
     *
     * @param Context $context
     * @param UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Get the form action URL
     *
     * Returns the appropriate URL for form submission.
     * If a custom URL is set, it returns that, otherwise, it defaults to a 'save' action URL.
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        // Check if the custom form action URL is set in the block data
        if ($this->hasData('form_action_url')) {
            return $this->getData('form_action_url');
        }

        // Return the default save URL for the controller
        return $this->urlBuilder->getUrl('*/*/save');
    }
}
