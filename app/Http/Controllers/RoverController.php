<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRoverDataException;
use App\Models\Rover;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class RoverController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Show the input/output form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('rovers');
    }

    /**
     * Process the input data
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function process(Request $request)
    {
        $roversInput =  preg_split('/\R/',$request->all()['roversInput']);
        $area = explode(" ",array_shift($roversInput));
        if(count($area)!=2 || !is_numeric($area[0]) || !is_numeric($area[1]))
            return response()->json(['error' => 'Area not correctly defined!'], 404);
        $output = '';
        while($rover = array_shift($roversInput)){
            try {
                $processingRover = new Rover([
                    Rover::START => $rover,
                    Rover::INSTRUCTIONS => array_shift($roversInput),
                    Rover::AREA => $area,
                ]);
                $output .= $processingRover->runRover() ;
            }catch(InvalidRoverDataException $e){
                $output .= $e->getMessage();
            }
            if(count($roversInput)) $output .= '\r\n';
        }
        return response()->json(['data'=>stripcslashes($output)]);
    }
}
