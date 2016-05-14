/**
 * startup.js
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */
pimcore.registerNS("pimcore.plugin.semantics");

pimcore.plugin.semantics = Class.create(pimcore.plugin.admin, {

    documentSemanticsTabs: {
        docs: {}
    },

    getClassName: function()
    {
        return "pimcore.plugin.semantics";
    },

    initialize: function()
    {
        pimcore.plugin.broker.registerPlugin(this);
    },
 
    pimcoreReady: function(params, broker)
    {
        //
    },

    postOpenDocument: function(doc)
    {
        var semanticsPanel = new pimcore.plugin.semantics.documentSemantics(doc);
        doc.tabbar.add(semanticsPanel.getLayout());

        this.documentSemanticsTabs.docs[doc.id] = semanticsPanel;
    }

});

var semanticsPlugin = new pimcore.plugin.semantics();

