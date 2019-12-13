<?php

namespace controllers\api_service;
use database\DB;
use core\lib\Request;
use core\lib\Response;

class CreateServicesController extends MainServicesController{


    public function createType(Request $request, Response $response){
        
     
        $id_type = null;

        if($request -> newTypeFlag){
            DB::insert('sr_types') -> addAssocValues([
                'type_name' =>  $request -> type_name,
                'id_user' =>  $this -> id_user,
                'created_at' => time(),
                'updated_at' => time()
            ]);
            
            $id_type = DB::select('sr_types') -> lastID("id_type");
        }
        else{
            $id_type = $request -> type_name;
        }
        DB::insert('sr_malf') -> addAssocValues([
            
            'created_at' => time(),
            'malf_name' => $request -> malf_name,
            'id_user' =>  $this -> id_user,
            'id_type' => $id_type
        ]);

        $types = $this -> getDataByIdUser('sr_types',[
            'id_type',
            'type_name'
        ]);
        $response -> sendJson($types);

    }
    public function createMalfunction(Request $request, Response $response){
        
        DB::insert('sr_malf_info') -> addAssocValues([
            'created_at' => time(),
            'updated_at' => time(),
            'id_malf' => $request -> id_malf,
            'id_user' =>  $this -> id_user,
            'id_status' => $request -> id_status,
            'id_variant' => $request -> id_variant,
            'number' => $request -> number,
        ]);

        $id_malf_info = DB::insert('sr_malf_info') -> lastID("id_malf_info");
        
        DB::insert('sr_history_statuses') -> addAssocValues([
            'created_at' => time(),
            'id_status' => $request -> id_status,
            'id_malf_info' => $id_malf_info,
            'id_user' =>  $this -> id_user,
            
        ]);
        $id_desc_malf_info = 0;
        
        if(!empty(trim($request -> description))) {
            DB::insert('sr_desc_malf_info') -> addAssocValues([
                'created_at' => time(),
                'updated_at' => time(),
                'id_malf_info' => $id_malf_info,
                'id_user' =>  $this -> id_user,
                'id_status' => $request -> id_status,
                'description' => trim($request -> description)
            ]);
        }
        $id_desc_malf_info = DB::insert('sr_desc_malf_info') -> lastID("id_desc_malf_info");

        
        // $response -> sendJson([
        //     'lastIDMalf' => $id_malf_info,
        //     'lastIDMalfDesc' => $id_desc_malf_info,
        // ]);
    }

    public function addNewDesc(Request $request, Response $response){
        if(!empty(trim($request -> description))) {
            
            $id_status =  (DB::select('sr_malf_info') -> findWhereAnd([
                'id_status',
                
            ],
            [
                ['id_user','=',$this -> id_user],
                ['id_malf_info','=',$request -> id_malf_info]
            ]
            ))[0]['id_status'];

            DB::insert('sr_desc_malf_info') -> addAssocValues([
                'created_at' => time(),
                'updated_at' => time(),
                'id_malf_info' => $request -> id_malf_info,
                'id_user' =>  $this -> id_user,
                'id_status' => $id_status,
                'description' => trim($request -> description)
            ]);
        }
        $id_desc_malf_info = DB::insert('sr_desc_malf_info') -> lastID("id_desc_malf_info");
        
        $res = array_map(function($el){
            $el['created_at'] = date('d.m.Y H:i:s',$el['created_at']);
            return $el;
        },DB::select('sr_desc_malf_info') -> findWhereAnd([
            'id_desc_malf_info',
            'created_at',
        ],
        [
            ['id_user','=',$this -> id_user],
            ['id_desc_malf_info','=',$id_desc_malf_info]
        ]
        ));
        
        $response -> sendJson($res[0]);
        
        
    }
}