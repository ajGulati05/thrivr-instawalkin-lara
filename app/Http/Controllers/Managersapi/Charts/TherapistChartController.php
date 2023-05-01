<?php

namespace App\Http\Controllers\Managersapi\Charts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TherapistApi\v2\Charts\TherapistChartDetailResource;
use App\Http\Resources\TherapistApi\v2\Charts\TherapistChartResource;
use App\Http\Traits\v2\ReconcileUserTypeTrait;
use Illuminate\Support\Facades\Validator;
use App\Chart;
class TherapistChartController extends Controller
{
   use ReconcileUserTypeTrait;



        public function create(Request $request){
            $client= $this->reconcileUser($request);
            $therapist=Auth::user();   
                 $request->validate([
                        'data'=>'required|string',
                        'chart_types_code'=>'required|string|exists:chart_types,code',
                 ]);


                       $data=[
        'data'=>request('data'),
        'chart_types_code' =>request('chart_types_code'),
        'manager_id'=>$therapist->id

        ];
   
            $chart=$client->chart()->create($data);
   
      return response()->json(["data"=> new TherapistChartDetailResource($chart),"status"=>true]);
        }


        public function append($clients,Chart $chart,Request $request){
            $client= $this->reconcileUser($request);
            $therapist=Auth::user();   
                 $request->validate([
                        'data'=>'required|string',
                 ]);


                       $data=[
                        'data'=>request('data'),
                        'chart_types_code' =>$chart->chart_types_code,
                        'manager_id'=>$therapist->id,
                        'parent_id'=>$chart->id
                         ];
   
            $newChart=$client->chart()->create($data);
   
      return response()->json(["data"=> new TherapistChartDetailResource($newChart),"status"=>true]);
        }


        public function list(Request $request){
                $therapist=Auth::user();    
                $charts=$therapist->charts;
                $client= $this->reconcileUser($request);
                //$clientCharts=$client->chartWithChildren;
                $clientCharts=$client->chart;


                return response()->json(["data"=> TherapistChartResource::collection($client->chart)->sortByDesc('created_at')->values()->all(),"status"=>true]);
        }   

           public function detail( $cleint,Chart $chart){
              
                $charts=$chart->load('children');
                 return response()->json(["data"=> new TherapistChartDetailResource($charts),"status"=>true]);
        }   

        public function lock($cleint,Chart $chart){
            $chart->locked=true;
            $chart->save();
            return response()->json(["data"=> new TherapistChartDetailResource($chart),"status"=>true]);
        }

         public function edit($cleint,Chart $chart,Request $request){
            if($chart->locked){
                return response()->json(["message"=>"Chart has already been locked","error"=>"Chart has already been locked","status"=>true]);
            }
                $request->validate([
                        'data'=>'required|string',
                 ]);

            $chart->data=request('data');
            $chart->save();
            return response()->json(["data"=> new TherapistChartDetailResource($chart),"status"=>true]);

        }

}


