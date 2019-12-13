<?php

namespace controllers\api_service;
use database\DB;
use core\lib\Request;
use core\lib\Response;

class EditServicesController extends MainServicesController{
    
    public function editMalf(Request $request, Response $response , $id_malf_info){
        
        DB::update('sr_malf_info') -> changeWhereAnd([
            ['id_status',$request -> id_status],
            ['id_variant',$request -> id_variant],
            ['id_malf',$request -> id_malf],
            ['number',$request -> number],
            ['updated_at',time()],
        ],[
            ['id_user','=',$this -> id_user],
            ['id_malf_info','=',$id_malf_info],
            ]);
       
        if($request -> flagChangeStatus){
            DB::insert('sr_history_statuses') -> addAssocValues([
                'created_at' => time(),
                'id_status' => $request -> id_status,
                'id_malf_info' => $id_malf_info,
                'id_user' =>  $this -> id_user,
                
            ]);
        }
       
            
    if(isset($request -> filterData['id_status'])){
        // echo 111;
        $id_status = (int) $request -> filterData['id_status'];
        $id_variant = (int) $request -> filterData['id_variant'];
        $id_malf = (int) $request -> filterData['id_malf'];
        $id_type = (int) $request -> filterData['id_type'];
    
        $where =  array_filter([
            [
            'sr_malf_info.id_user',
            '=',
            $this -> id_user
            ],
            $id_type > 0 ? ['sr_malf.id_type','=', $id_type ] : null,
            $id_status > 0 ? ['sr_malf_info.id_status','=', $id_status ] : null,
            $id_malf > 0 ? ['sr_malf_info.id_malf','=', $id_malf ] : null,
            $id_variant > 0 ? ['sr_malf_info.id_variant','=', $id_variant ] : null,
        ],function($el){
            return !is_null($el);
        });
     
        $res = array_map(function($el){
            $el['created_at'] = date('d.m.Y H:i:s',$el['created_at']);
            $el['updated_at'] = date('d.m.Y H:i:s',$el['updated_at']);
            return $el;
        },DB::select('sr_malf')->findJoinWhereAnd(
        [ 
            'sr_malf_info.id_malf_info',
            'sr_malf.malf_name',
            'sr_malf_info.id_malf',
            'sr_malf_info.id_status',
            'sr_malf_info.id_variant',
            'sr_malf_info.number',
            'sr_statuses.status_name',
            'sr_variants_use.variant_name',
            'sr_types.id_type',
            'sr_types.type_name',
            'sr_malf_info.created_at',
            'sr_malf_info.updated_at',
        ],
        [
            'sr_malf_info, sr_malf_info.id_malf=sr_malf.id_malf',
            'sr_statuses, sr_statuses.id_status = sr_malf_info.id_status',
            'sr_types, sr_types.id_type = sr_malf.id_type',
            'sr_variants_use, sr_variants_use.id_variant=sr_malf_info.id_variant'
        ],
        $where
    ));
        
        $response -> sendJson($res);
    }
    
    else{

        $res = array_map(function($el){
            $el['created_at'] = date('d.m.Y H:i:s',$el['created_at']);
            $el['updated_at'] = date('d.m.Y H:i:s',$el['updated_at']);
            return $el;
        },DB::select('sr_malf')->findJoinWhereAnd(
        [ 
            'sr_malf_info.id_malf_info',
            'sr_malf.malf_name',
            'sr_malf_info.number',
            'sr_statuses.status_name',
            'sr_variants_use.variant_name',
            'sr_types.type_name',
            'sr_statuses.name_icon',
            'sr_statuses.color_icon',
            'sr_malf_info.created_at',
            'sr_malf_info.updated_at',
        ],
        [
            'sr_malf_info, sr_malf_info.id_malf=sr_malf.id_malf',
            'sr_statuses, sr_statuses.id_status = sr_malf_info.id_status',
            'sr_types, sr_types.id_type = sr_malf.id_type',
            'sr_variants_use, sr_variants_use.id_variant=sr_malf_info.id_variant'
        ],
        [
            [
            'sr_malf_info.id_user',
            '=',
            $this -> id_user
            ],
            [
            'sr_malf_info.id_malf_info',
            '=',
            $id_malf_info
            ]
        ]
        ));

        $response -> sendJson($res);
    }
}
}