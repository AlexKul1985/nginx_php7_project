<?php

namespace controllers\api_service;
use database\DB;
use core\lib\Request;
use core\lib\Response;

class GetServicesController extends MainServicesController{
    
    public function getTypes(Request $request, Response $response){
        $types = $this -> getDataByIdUser('sr_types',[
            'id_type',
            'type_name'
        ]);

        $response -> sendJson($types);
    }
    public function getFullInfo(Request $request, Response $response){
        $types = DB::select('sr_types')->findWhereAnd([
            'id_type',
            'type_name'
        ],
        [
            ['id_user',"=",$this -> id_user]
        ]);
        $statuses = DB::select('sr_statuses')->find([
            'id_status',
            'status_name'
        ]);
        $variants = DB::select('sr_variants_use')->find([
            'id_variant',
            'variant_name'
        ]);
        $response -> sendJson(
            [
            'types' => $types,
            'statuses' => $statuses,
            'variants' => $variants
            ]
        );
    } 

    public function getNamesByIdType(Request $request,Response $response,$id_type){
        $malfs = DB::select('sr_malf') -> findWhereAnd(
        [
            'id_malf',
            'malf_name'
        ],
        [
            ['id_type',"=",$id_type],
            ['id_user',"=",$this -> id_user]
        ]);
        
        $response -> sendJson($malfs);
    }

    public function testJoinWhereAnd(Request $request,Response $response){

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
            ]
        ]
        ));


        $response -> sendJson($res);
       
        
        
    }

    public function filterServicesList(Request $request, Response $response){
       
        $id_status = (int) $request -> id_status;
        $id_variant = (int) $request -> id_variant;
        $id_malf = (int) $request -> id_malf;
        $id_type = (int) $request -> id_type;
    
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

    public function getDetailMalfInfo(Request $request, Response $response, $id_malf_info){
        $res = array_map(function($el){
            $el['created_at'] = date('d.m.Y H:i:s',$el['created_at']);
            $el['updated_at'] = date('d.m.Y H:i:s',$el['updated_at']);
            return $el;
        },DB::select('sr_malf')->findJoinWhereAnd(
        [ 
            'sr_malf_info.id_malf_info',
            'sr_malf.malf_name',
            'sr_malf_info.number',
            'sr_statuses.id_status',
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

    public function testGetListDesc(Request $request, Response $response,$id_malf_info){
        
        $res = array_map(function($el){
            $el['created_at'] = date('d.m.Y H:i:s',$el['created_at']);
            return $el;
        },DB::select('sr_desc_malf_info') -> findWhereAnd([
            'id_desc_malf_info',
            'created_at',
        ],
        [
            ['id_user','=',$this -> id_user],
            ['id_malf_info','=',$id_malf_info]
        ]
        ));
        
        $response -> sendJson($res);
            

    }

    public function getHistoryStatuses(Request $request, Response $response, $id_malf_info){
        
        $res = array_map(function($el){
            $el['created_at'] = date('d.m.Y H:i:s',$el['created_at']);
            
            return $el;
        },DB::select('') -> nativeSqlRequest('
            SELECT sr_history_statuses.id_history_status, sr_history_statuses.id_status, sr_statuses.status_name, sr_history_statuses.created_at, sr_statuses.name_icon, sr_statuses.color_icon FROM sr_history_statuses
            JOIN sr_statuses ON sr_statuses.id_status=sr_history_statuses.id_status WHERE sr_history_statuses.id_malf_info=? AND sr_history_statuses.id_user=? ORDER BY sr_history_statuses.id_history_status DESC
        ', [$id_malf_info, $this -> id_user]));
        
        $response -> sendJson($res);
    }

    public function testGetDesc(Request $request, Response $response, $id_malf_info, $id_desc_malf_info){
        // echo $id_malf_info;
        // echo $id_desc_malf_info;
        $res = array_map(function($el){
            $el['created_at'] = date('d.m.Y H:i:s',$el['created_at']);
            return $el;
        },DB::select('sr_desc_malf_info') -> findWhereAnd([
            'id_desc_malf_info',
            'created_at',
            'description'
        ],
        [
            ['id_user','=',$this -> id_user],
            ['id_desc_malf_info','=',$id_desc_malf_info],
            ['id_malf_info','=',$id_malf_info],
        ]
        ));
        
        $response -> sendJson($res[0]);
        // print_r($res[0]);
    }

    public function getDataEdit(Request $request, Response $response , $id_malf_info){
        $editData = DB::select('sr_malf_info') -> findJoinWhereAnd([
            'sr_malf.id_malf',
            'sr_malf.id_type',
            'sr_malf_info.id_malf_info',
            'sr_malf_info.number',
            'sr_malf_info.id_status',
            'sr_malf_info.id_variant',

        ],[
            'sr_malf, sr_malf.id_malf = sr_malf_info.id_malf'
        ],[
            ['sr_malf_info.id_user','=',$this -> id_user],
            ['sr_malf_info.id_malf_info','=',$id_malf_info],
        ]);
        $malfsData = DB::select('sr_malf') -> findWhereAnd([
           'id_malf',
           'malf_name'

        ],[
            ['id_user','=',$this -> id_user],
            ['id_type','=',$editData[0]['id_type']],
        ]);
        
        $response -> sendJson(['editData' => $editData[0],'names' => $malfsData]);
    }

    public function testGroupBy(Request $request, Response $response){
        
        $statuses = DB::select('sr_statuses') -> all();
        
        $ids = array_map(function($el){
            return $el['id_status'];
        }, $statuses);
        
        $labels = array_map(function($el){
            return $el['status_name'];
        }, $statuses);

        $backgroundColor = array_map(function($el){
            return $el['color_icon'];
        }, $statuses);
        
        
        $res = DB::select('sr_statuses') -> findJoinWhereGroupBy([
            'COUNT(`sr_malf_info`.`id_malf_info`) as `count`',
            'sr_malf_info.id_status',
            'sr_statuses.status_name',
            'sr_statuses.color_icon',
        ],[
            'sr_malf_info, sr_malf_info.id_status = sr_statuses.id_status'
        ], 'sr_malf_info.id_user', '=',$this -> id_user, 'sr_malf_info.id_status');

        $data = array_map(function($el) use ($res){
            foreach ($res as $value) {
                if($el == $value['id_status']){
                    return $value['count'];
                }
            }
            return 0;
        }, $ids);

        $resultData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'backgroundColor' => $backgroundColor,
                    'data' => $data
                ]
            ]
            ];

        $response -> sendJson($resultData);
    }
}