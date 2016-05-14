<?php
/**
 * Service
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */

namespace Semantics\Model\DocumentSemantic;

use Pimcore\Tool;
use Pimcore\Model\Document;
use Semantics\Model\DocumentSemantic;

class Service
{

    public static function initControllerPlugin($event)
    {
        /**
         * @var \Zend_Controller_Front $front
         */
        $front = $event->getTarget();

        if (Tool::useFrontendOutputFilters(new \Zend_Controller_Request_Http())) {
            $front->registerPlugin(new \Semantics\Controller\Plugin\Semantics(), 933);
        }

    }

    /**
     * Returns the JSONLD code for a given document
     * @param Document $document
     * @return null|string
     */
    public static function getDocumentJsonLd(Document $document)
    {

        $semantic = DocumentSemantic::getByDocumentId($document->getId());

        if (!$semantic || !$semantic->getJsonLd()) {
            return null;
        }

        $code = '<script type="application/ld+json">' . PHP_EOL;
        $code .= $semantic->getJsonLd() . PHP_EOL;
        $code .= '</script>';

        return $code;
    }



}