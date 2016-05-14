/**
 * documentSemantics.js
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */
pimcore.registerNS("pimcore.plugin.semantics.documentSemantics");
pimcore.plugin.semantics.documentSemantics = Class.create({

    initialize: function(item)
    {
        this.item = item;
    },

    getLayout: function()
    {

        if (this.iframe == null) {

            this.iframeName = "documentSemantics_iframe_" + this.item.id;

            this.framePanel = new Ext.Panel({
                border: false,
                region: "center",
                bodyStyle: "-webkit-overflow-scrolling:touch; background:#323232;",
                html: [
                    '<iframe src="/plugin/Semantics/index/manage?documentId=',this.item.id,
                    '" width="100%" height="100%" frameborder="0" id="',this.iframeName,
                    '" name="',this.iframeName,
                    '" style="background: #fff;"></iframe>'
                ].join('')
            });

            this.iframe = new Ext.Panel({
                title: "Document Semantics",
                border: false,
                layout: "border",
                autoScroll: true,
                closeable: false,
                iconCls: "semantics_icon_documentSemantics",
                items: [this.framePanel]
            });

        }

        return this.iframe;
    },

    onClose: function () {
        try {
            window[this.iframeName].location.href = "about:blank";
            Ext.get(this.iframeName).remove();
            delete window[this.iframeName];
        } catch (e) { }
    }

});