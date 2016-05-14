<?php
/**
 * Semantics
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */

namespace Semantics\Controller\Plugin;

use Pimcore\Tool;
use Pimcore\Model\Document;
use Semantics\Model\DocumentSemantic;

class Semantics extends \Zend_Controller_Plugin_Abstract
{

    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @var Document\Page $document
     */
    protected $document;

    /**
     * @param \Zend_Controller_Request_Abstract $request
     * @return bool|void
     */
    public function routeShutdown(\Zend_Controller_Request_Abstract $request)
    {
        if (!Tool::useFrontendOutputFilters($request)) {
            return $this->disable();
        }

        if ($request->getParam("document") instanceof Document\Page) {
            $this->document = $request->getParam("document");
        } else {
            return $this->disable();
        }

    }

    /**
     * @return bool
     */
    public function disable()
    {
        $this->enabled = false;
        return true;
    }

    /**
     * inserts the JSONLD Code after the head tag
     */
    public function dispatchLoopShutdown()
    {
        if (!Tool::isHtmlResponse($this->getResponse())) {
            return;
        }

        if ($this->enabled && $this->document) {

            $code = DocumentSemantic\Service::getDocumentJsonLd($this->document);

            if ($code) {
                // jsonLd
                $body = $this->getResponse()->getBody();

                $headEndPosition = stripos($body, "</head>");
                if ($headEndPosition !== false) {
                    $body = substr_replace($body, $code."</head>", $headEndPosition, 7);
                }

                $this->getResponse()->setBody($body);

            }
        }

    }


}