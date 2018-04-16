Exemplo de inicialização:
```
<?php require_once "../_app/Library/Table/www/templates/css/template-css.phtml"?>
<div id="tableContainer"></div>
<?php require_once "../_app/Library/Table/www/templates/js/template-js.phtml"?>
<script>
    $("#tableContainer").zfTable("../_app/Library/Table/src/Controller/Post.ajax.php?wc=table/home")
</script>

```
Na pasta _ajax voce de criar um no case para o status exemplo:
```
case 'manager_status':
        $PostId = $PostData['del_id'];;
        $CampoStatus = $PostData['campo'];
        $Status = $PostData['status'];;
        unset($PostData['post_id']);
        if ($Status) {
            $Status = 0;
        } else {
            $Status = 1;
        }
        $Update->ExeUpdate(DB_POSTS, [
            $CampoStatus => $Status
        ], "WHERE post_id = :id", "id={$PostId}");
        $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>TUDO CERTO: </b> O Status do registro foi atualizado com sucesso!");
        break;
            ```