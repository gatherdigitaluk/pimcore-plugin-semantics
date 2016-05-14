<?php

/**
 * Plugin
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */

namespace Semantics;

use Pimcore\API\Plugin as PluginLib;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface
{

    public function init()
    {
        parent::init();

        if (!self::isInstalled()) {
            return;
        }

        \Pimcore::getEventManager()->attach("system.startup", ["\\Semantics\\Model\\DocumentSemantic\\Service", "initControllerPlugin"]);
    }

    public static function install()
    {
        $sql = "CREATE TABLE `plugin_document_semantics` (
              `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
              `documentId` int(11) unsigned NOT NULL,
              `jsonLd` longtext NULL
            ) COMMENT='';";

        $db = \Pimcore\Db::get();
        $result = $db->query($sql);

        return 'Semantics Installed Successfully!';
    }

    public static function uninstall()
    {
        $sql = "DROP TABLE `plugin_document_semantics`;";
        $db = \Pimcore\Db::get();
        $result = $db->query($sql);

        return 'Semantics Uninstalled Successfully!';
    }

    public static function isInstalled()
    {
        $db = \Pimcore\Db::get();

        //check the table it present
        return $db->query("SHOW TABLES LIKE 'plugin_document_semantics'")->rowCount() > 0;
    }



}
