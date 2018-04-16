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
Adicionar atributos

```
//Attr and class for table
$this->addClass('tableClass');
$this->addAttr('tableAttr', 'tableAttrValue');

 //Attr and class for header
$this->getHeader('name')->addAttr('attr', 'example');
$this->getHeader('name')->addClass('new-class');

 //Attr and class for row
$this->getRow()->addAttr('test', 'newattr');
$this->getRow()->addClass('class', 'nowaklasa1');

 //Attr and class for cell
$this->getHeader('surname')->getCell()->addAttr('cellAttr', 'cellAttrValue');
$this->getHeader('surname')->getCell()->addDecorator('class', array('class' => 'sss'));
```      
Separar por grupo

```

class Separatable extends AbstractTable
{
    
    protected $config = array(
        'name' => 'Separatable decorator',
        'showPagination' => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
    );
    
    //Definition of headers
    protected $headers = array(
        'idcustomer' => array('title' => 'Id', 'width' => '50') ,
        'name' => array('title' => 'Name' , <strong>'separatable' => true</strong>),
        'surname' => array('title' => 'Surname' ),
        'street' => array('title' => 'Street'),
        'city' => array('title' => 'City' , <strong>'separatable' => true</strong>),
        'active' => array('title' => 'Active' , 'width' => 100 ),
    );

    public function init()
    {
        <strong>$this->getRow()->addDecorator('separatable', array('defaultColumn' => 'city'));</strong>
    }

    protected function initFilters(\Zend\Db\Sql\Select $query)
    {
    }
} 
```

Condições

```
$this->getHeader('name')->getCell()->addDecorator('link', array(
    'url' => '/table/link/id/%s',
    'vars' => array('idcustomer')
))->addCondition('equal', array('column' => 'name', 'values' => 'Jan'));

 $this->getHeader('city')->getCell()->addDecorator('link', array(
    'url' => '/table/link/id/%s',
    'vars' => array('idcustomer')
))->addCondition('equal', array('column' => 'city', 'values' => 'Warszawa'));
```
