<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UniformRequest;
use App\Models\Uniform;
use Exception;

class UniformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($orderId)
    {
        try {
            $uniforms = Uniform::where('order_id', $orderId)->get();
            return response($uniforms, 200);

        } catch (Exception $e) {
            $res = [];
            $res['error'] = 'Ha occurrido un error en la base de datos, intentelo mas tarde';
            return response($res, 400);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UniformRequest $request)
    {
        try {
            $uniform = new Uniform;
            $uniform->order_id = $request->order_id;
            $uniform->legend = $request->legend;
            $uniform->number = $request->number;
            $uniform->size = $request->size;

            $uniform->save();

            return response($uniform, 200);

        } catch (Exception $e) {
            $res = [];
            if ($e->getCode() == 23000) {
                $res['error'] = 'No existe una orden asociada al id especificado';
            } elseif ($e->getCode() == '01000') {
                $res['error'] = 'El valor de la talla no es válido';
            } else {
                $res['error'] = 'Ocurrió un error en la base de datos, inténtelo de nuevo más tarde';
            }
            return response($res, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
    }
}
