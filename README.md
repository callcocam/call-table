Exemplo de inicialização:
```
<?php require_once "../_app/Library/Table/www/templates/css/template-css.phtml"?>
<div id="tableContainer"></div>
<?php require_once "../_app/Library/Table/www/templates/js/template-js.phtml"?>
<script>
    $("#tableContainer").zfTable("../_app/Library/Table/src/Controller/Post.ajax.php?wc=table/home")
</script>

``
