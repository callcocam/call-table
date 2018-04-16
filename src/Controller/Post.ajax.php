<?php

session_start();
require '../../../../../_app/Config.inc.php';
$NivelAcess = LEVEL_WC_CONFIG_API;

if (empty($_SESSION['userLogin']) || empty($_SESSION['userLogin']['user_level']) || $_SESSION['userLogin']['user_level'] < $NivelAcess):
    $jSON['trigger'] = AjaxErro('<b class="icon-warning">OPPSSS:</b> Você não tem permissão para essa ação ou não está logado como administrador!', E_USER_ERROR);
    echo json_encode($jSON);
    die;
endif;

        $table = new \Table\Model\Posts();
        $Params = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        $table->setSource(DB_POSTS)
            ->setParamAdapter($Params);
        $Result =$table->render();
        //$Result =$table->render('custom','custom');
       // $Result =$table->render('newDataTableJson');
        if(is_array($Result)){
        var_dump($Result);
        }
        else{
            echo $Result;
        }