<?php
/**
 * manage.php
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */
?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <script src="//code.jquery.com/jquery-1.12.2.min.js" integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
    <script src="http://ajaxorg.github.io/ace-builds/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
    <!-- <script src="//cdn.jsdelivr.net/g/es6-promise@1.0.0"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jsonld/0.3.15/jsonld.js"></script> -->
    <link rel="stylesheet" href="/plugins/Semantics/static/css/manage-semantics.css?<?= time(); ?>">
    <style type="text/css" media="screen">
        #editor {
            height: 300px;
            width: 600px;
            font-family:monospace;
        }
        .ace_editor, .ace_content {
            font-family:monospace!important
        }
    </style>
</head>
<body>
    <form method="post">
        <fieldset class="x-fieldset">
            <legend>JSONLD Editor</legend>
            <div id="editor"><?= $this->documentSemantic->getJsonLd() ?: '{}'; ?></div>
            <?= $this->formHidden('jsonLd', $this->documentSemantic->getJsonLd(), [ 'id' => 'jsonLd' ]); ?>
            <div class="not-valid" style="display:none;">Not Valid JSON</div>
            <button id="submit" class="save-tags-button" type="submit" name="task" value="save-semantic">Save</button>
        </fieldset>
    </form>

    <script>
        $(function() {

            function validateJsonLd() {
                var jsonString = editor.getValue();
                try {
                    var jsonObj = JSON.parse(jsonString);
                    $('.not-valid').hide();
                    $('#jsonLd').val(jsonString);
                    $('#submit').show();
                } catch(e) {
                    $('.not-valid').show();
                    $('#submit').hide();
                }
            }

            var theTimeout;
            var editor = ace.edit("editor");
                editor.getSession().setMode("ace/mode/json");
                editor.renderer.setScrollMargin(20,20);
                editor.on("change", function() {
                    clearTimeout(theTimeout);
                    theTimeout = setTimeout(validateJsonLd, 200);
                });
                document.getElementById('editor').style.fontSize='14px';

            window.parent.addEventListener("resize", function() {
                editor.resize();
            });

        });



    </script>

</body>
</html>
