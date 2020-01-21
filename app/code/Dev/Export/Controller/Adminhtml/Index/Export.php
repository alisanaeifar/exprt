<?php

declare(strict_types=1);

namespace Dev\Export\Controller\Adminhtml\Index;

class Export extends \Magento\Framework\App\Action\Action
{

    protected $resultRawFactory;

    protected $csvWriter;

    protected $fileFactory;

    protected $directoryList;


    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\File\Csv $csvWriter,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        $this->csvWriter = $csvWriter;
        $this->resultRawFactory = $resultRawFactory;
        $this->fileFactory = $fileFactory;
        $this->directoryList = $directoryList;

        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = [
            ['column 1','column 2','column 3'],
            ['row 1','row 1','row 1'],
            ['row 2','row 2','row 2'],
        ];

        $fileDirectory = \Magento\Framework\App\Filesystem\DirectoryList::MEDIA;
        $fileName = 'experius_codeblog_csv.csv';
        $filePath =  $this->directoryList->getPath($fileDirectory) . "/" . $fileName;

        $this->csvWriter
            ->setEnclosure('"')
            ->setDelimiter(',')
            ->saveData($filePath ,$data);

        $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename",
                'value' => $fileName,
                'rm'    => true,
            ],
            \Magento\Framework\App\Filesystem\DirectoryList::MEDIA,
            'text/csv',
            null
        );

        $resultRaw = $this->resultRawFactory->create();

        return $resultRaw;
    }
}




