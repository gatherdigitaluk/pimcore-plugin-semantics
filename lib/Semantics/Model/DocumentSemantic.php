<?php

/**
 * DocumentSemantic
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */

namespace Semantics\Model;

use Pimcore\Model\AbstractModel;

class DocumentSemantic extends AbstractModel
{

    /**
     * @var int $id
     */
    public $id;

    /**
     * @var int $documentId
     */
    public $documentId;

    /**
     * @var string $jsonLd
     */
    public $jsonLd;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return DocumentSemantic
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * @param int $documentId
     * @return DocumentSemantic
     */
    public function setDocumentId($documentId)
    {
        $this->documentId = $documentId;

        return $this;
    }

    /**
     * @return string
     */
    public function getJsonLd()
    {
        return $this->jsonLd;
    }

    /**
     * @param string $jsonLd
     * @return DocumentSemantic
     */
    public function setJsonLd($jsonLd)
    {
        $this->jsonLd = $jsonLd;

        return $this;
    }


    /**
     * @param int $id
     * @return DocumentSemantic
     */
    public static function getById($id)
    {
        $obj = new self;

        try {
            $obj->getDao()->getById($id);
        } catch(\Exception $w) {
            return false;
        }

        return $obj;
    }

    /**
     * @param int $id
     * @return DocumentSemantic
     */
    public static function getByDocumentId($id)
    {
        $obj = new self;

        try {
            $obj->getDao()->getByDocumentId($id);
        } catch(\Exception $w) {
            return false;
        }

        return $obj;
    }


    public function save()
    {
        return $this->getDao()->save();
    }

    public function delete()
    {
        return $this->getDao()->delete();
    }


}