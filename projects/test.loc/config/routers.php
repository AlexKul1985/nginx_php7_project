<?php
use core\lib\Router;
// use database\DB;
//create
Router::toEvent('/create_type','controllers\api_service\CreateServicesController@createType');
Router::toEvent('/createmalf','controllers\api_service\CreateServicesController@createMalfunction');
Router::toEvent('/newdescadd','controllers\api_service\CreateServicesController@addNewDesc');

//get
Router::toEvent('/types','controllers\api_service\GetServicesController@getTypes');
Router::toEvent('/fullinfo','controllers\api_service\GetServicesController@getFullInfo');
Router::toEvent('/names/:id_type','controllers\api_service\GetServicesController@getNamesByIdType');
Router::toEvent('/test/join','controllers\api_service\GetServicesController@testJoinWhereAnd');
Router::toEvent('/filter','controllers\api_service\GetServicesController@filterServicesList');
Router::toEvent('/detail/:id_malf_info','controllers\api_service\GetServicesController@getDetailMalfInfo');
Router::toEvent('/malf/:id_malf_info/desclist','controllers\api_service\GetServicesController@testGetListDesc');
Router::toEvent('/gethistorystatuses/:id_malf_info','controllers\api_service\GetServicesController@getHistoryStatuses');
Router::toEvent('/malf/:id_malf_info/desclist/:id_desc_malf_info','controllers\api_service\GetServicesController@testGetDesc');
Router::toEvent('/getdataedit/:id_malf_info','controllers\api_service\GetServicesController@getDataEdit');
Router::toEvent('/main','controllers\api_service\GetServicesController@testGroupBy');

//edit
Router::toEvent('/editmalf/:id_malf_info','controllers\api_service\EditServicesController@editMalf');

//delete
Router::toEvent('/delmalfinfo','controllers\api_service\DeleteServicesController@deleteMalfInfo');

//auth
Router::toEvent('/auth','controllers\api_service\MainServicesController@actionAuth');











?>