<?php
/**
 * IndexController
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */

use Pimcore\Model\Document;
use Semantics\Model\DocumentSemantic;

class Semantics_IndexController extends \Pimcore\Controller\Action\Admin
{

    /**
     * @var int $documentId
     */
    protected $documentId;

    /**
     * @var Document $document
     */
    protected $document;

    /**
     * @var DocumentSemantic $documentSemantic
     */
    protected $documentSemantic;


    /**
     * Handle the item
     */
    public function preDispatch()
    {
        parent::preDispatch();

        $this->documentId  = (int) $this->getParam('documentId', 0);
        $this->document = Document::getById($this->documentId);

        if (!$this->document) {
            throw new \Exception('Document was not found');
        }

        //try to get an existing document semantic for the item
        $this->documentSemantic = DocumentSemantic::getByDocumentId($this->document->getId());

        if (!$this->documentSemantic) {
            $this->documentSemantic = new DocumentSemantic();
            $this->documentSemantic ->setDocumentId($this->document->getId())
                                    ->save();
        }

        $this->view->documentSemantic = $this->documentSemantic;

    }

    /**
     * Sets the tags given an item and type
     */
    public function manageAction()
    {

        if ($this->getParam('task') == 'save-semantic') {
            $jsonLd = $this->getParam('jsonLd');
            $this->documentSemantic->setJsonLd($jsonLd);
            $this->documentSemantic->save();
        }

    }


}
