<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\campaign;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['campaign']=campaign::all();

      if(count($data['campaign'])===0){
        return response()->json([
            'response_code'=>'00',
            'response_message'=>'Data Empty',
            'data'=>$data
        ],200);
      }else{
        return response()->json([
            'response_code'=>'00',
            'response_message'=>'Data Show',
            'data'=>$data
        ],200);   
      }
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'title' => 'required',
            
            'description' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,png,jpg,jpeg',
            'required' => 'required',
            'collected' => 'required',
        ]);     

        $campaign = new campaign;
        $campaign->title = $request->title;
        $campaign->collected = $request->collected;
        $campaign->description = $request->description;
        $campaign->address = $request->address;
        $campaign->image = $request->image;
        $campaign->required = $request->required;

        if($request->hasFile('image')){
        $image = $request->file('image');
        $image_extension = $image->getClientOriginalExtension();
        $image_name = time().'.'.$image_extension;
        $image_folder = '/photo/campaign/';
        $image_location = $image_folder . $image_name;

        try{
            $image->move(public_path($image_folder), $image_name);
            $campaign->image = $image_location;
        }catch(\Throwable $th){
            return response()->json([
                'response_code'=>'01',
                'response_message'=>'Fail to Upload Image',
                'data'=>$campaign
            ],400);
        }
        }
        $campaign->save();
        
        return response()->json([
            'response_code'=>'00',
            'response_message'=>'Campaign Created',
            'data'=>$campaign
        ],201);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = campaign::find($id);

        if($data){
          return response()->json([
              'response_code'=>'00',
              'response_message'=>'Data Show',
              'data'=>$data
          ],200);
        }else{
          return response()->json([
              'response_code'=>'00',
              'response_message'=>'Data Not Found',
           
          ],400);   
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',        
            'description' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,png,jpg,jpeg',
            'required' => 'required',
            'collected' => 'required',
        ]);   
 
        $campaign = campaign::find($id);
 
        $campaign->title = $request->title;
        $campaign->collected = $request->collected;
        $campaign->description = $request->description;
        $campaign->address = $request->address;
        $campaign->image = $request->image;
        $campaign->required = $request->required;

        if($request->hasFile('image')){
        $image = $request->file('image');
        $image_extension = $image->getClientOriginalExtension();
        $image_name = time().'.'.$image_extension;
        $image_folder = '/photo/campaign/';
        $subCampaign = substr($campaign->image,1);
        File::delete($subCampaign);
        $image_location = $image_folder . $image_name;

        try{
            $image->move(public_path($image_folder), $image_name);
            $campaign->image = $image_location;
        }catch(\Throwable $th){
            return response()->json([
                'response_code'=>'01',
                'response_message'=>'Fail to Upload Image',
                'data'=>$campaign
            ],400);
        }
        }
        $campaign->save();
        
        return response()->json([
            'response_code'=>'00',
            'response_message'=>'Campaign Created',
            'data'=>$campaign
        ],201);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = campaign::find($id);
        $data->delete();

        if($data){
          return response()->json([
              'response_code'=>'00',
              'response_message'=>'Data Delete',
          ],200);
        }else{
          return response()->json([
              'response_code'=>'00',
              'response_message'=>'Data Not Found',
           
          ],400);   
        }
        //
    }
}
