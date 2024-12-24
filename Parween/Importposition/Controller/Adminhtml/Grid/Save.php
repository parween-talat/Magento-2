<?php
namespace Parween\Importposition\Controller\Adminhtml\Grid;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\ResourceConnection;


class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Parween\Importposition\Model\GridFactory
     */
   
    protected $messageManager; 
    protected $filesystem;
    protected $fileUploader;

    protected $_mediaDirectory;
    protected $_fileUploaderFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Parween\Importposition\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context, 
        \Magento\Framework\Filesystem\Driver\File $file,
        ManagerInterface $messageManager,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        ResourceConnection $resourceConnection
    )
    {
        
        $this->messageManager = $messageManager;
        $this->filesystem = $filesystem;
        
        $this->resourceConnection = $resourceConnection;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);
        

    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
    
    $resultRedirect = $this->resultRedirectFactory->create();
    try{
        $target = $this->_mediaDirectory->getAbsolutePath('category-position/');        
        
        $uploader = $this->_fileUploaderFactory->create(['fileId' => 'upload_custom_file']); //Since in this example the input 
        $uploader->setAllowedExtensions(['jpg', 'pdf', 'doc', 'png', 'zip', 'doc', 'csv']);
        
        $uploader->setAllowRenameFiles(true);
        
        $result = $uploader->save($target);
        
        echo '<pre>';
        print_r($result);
        if ($result['file']) {
            
            
            
            $path  =  $result['path'].$result['file'];
            $file = fopen($path, "r");
            
             $connection = $this->resourceConnection->getConnection();
        // $table is table name
        $product_table = $connection->getTableName('catalog_product_entity');
        $catalog_category_product = $connection->getTableName('catalog_category_product');
        //For Select query
        
            $i = 0;
            while (($row = fgetcsv($file, 100000, ",")) !== false) {
                    print_r($row);
                    if($i > 0){
                        // Get product id
                    $query = "SELECT * FROM " . $product_table. " WHERE sku = '".$row[0]."'";
                    $result = $connection->fetchAll($query);

                    if (isset($result[0]['entity_id'])) {

                    echo "<pre>";
                    print_r($result[0]);
                    
                    echo $product_id = $result[0]['entity_id'];
                    
                // update position

                $position = explode(",",$row[1]);
            print_r($position);
            
                for($j=0; $j < count($position); $j++){
                    $cat_id = explode("#",$position[$j]);
                print_r($cat_id);   
                echo    $cat_newid = trim($cat_id[0]);
                echo    $cat_position = trim($cat_id[1]);
                
                
                //$result = $connection->fetchAll($query);
                echo $update_query = "UPDATE `" . $catalog_category_product . "` SET `position`= '$cat_position' WHERE category_id = $cat_newid and product_id = $product_id ";
               $resultupdate =  $connection->query($update_query);
                echo "<pre>";
                //print_r($resultupdate);
                
                }
                }
                }
        $i++;
        
    }
    
        fclose($file);
            
        $this->messageManager->addSuccess(__('File has been successfully uploaded'));
            
        }
    } catch (\Exception $e) {
        $this->messageManager->addError($e->getMessage());
    }
    return $this->resultRedirectFactory->create()->setPath(
        '*/*/', ['_secure'=>$this->getRequest()->isSecure()]
    );            
}
    
//  public function uploadFile()
//  {
//  // this folder will be created inside "pub/media" folder
//  $yourFolderName = 'category-position/';
 
//  // "upload_custom_file" is the HTML input file name
//  $yourInputFileName = 'upload_custom_file';
//  echo "here";

//  try{
     
//   echo '<pre>';
//   print_r($_REQUEST);
//   $data = $this->getRequest()->getPostValue();

// print_r($data);
    
     
// $file = $this->getRequest()->getFiles($yourInputFileName);
// $file = $_REQUEST['upload_custom_file'];


//  echo "in";
 
//  $target = $this->mediaDirectory->getAbsolutePath($yourFolderName); 
 
//  /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
//  $uploader = $this->fileUploader->create(['fileId' => $yourInputFileName]);
//  echo "in2";
//  // set allowed file extensions
//  $uploader->setAllowedExtensions(['jpg', 'pdf', 'doc', 'png', 'zip','csv' ]);
 
//  // allow folder creation
//  $uploader->setAllowCreateFolders(true);
 
//  // rename file name if already exists 
//  $uploader->setAllowRenameFiles(true); 
 
//  // upload file in the specified folder
//  $result = $uploader->save($target);
 
//  //echo '<pre>'; print_r($result); exit;
 
//  if ($result['file']) {
//  $this->messageManager->addSuccess(__('File has been successfully uploaded.')); 
//  }
 
//  return $target . $uploader->getUploadedFileName();
 
//  } catch (\Exception $e) {
//  $this->messageManager->addError($e->getMessage());
//  }
 
//  return false;
//  }
    
}