<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Auth\Events\Validated;
// use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderUpdateRequest;
use Exception;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orders = Order::all();
            return response($orders, 200);
        } catch (Exception $e) {
            $res = ['error' => 'Hubo un problema con la base de datos, inténtelo más tarde.'];
            return response($res, 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {       
        try {
            // Store the file
            $filePath = $request->file('logo')->store('order_images', 'public');

            // Create the order
            $order = new Order;
            $order->team_name = $request->team_name;
            $order->typography = $request->typography;
            $order->colors = $request->colors;
            $order->logo = $filePath;
            $order->date = $request->date;
            $order->is_in_progress = $request->is_in_progress === 'true' ? true : false;

            // Save the order in database
            $order->save();

            return response($order, 200);
        } catch (Exception $e) {
            $res = ['error' => 'Hubo un problema con la base de datos, inténtelo más tarde.', 'e' => $e->getMessage()];
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
        try {
            // Get the order
            $order = Order::find($id);

            if($order) {
                return response($order, 200);
            } else {
                $res = ['error' => 'La orden solicitada no existe.'];
                return response($res, 404);
            }
        } catch(Exception $e) {
            $res = ['error' => 'Hubo un problema con la base de datos, intentelo más tarde.'];
            return response($res, 400);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, $id)
    {
        try {
            // Get the order
            $order = Order::find($id);

            if ($order) {
                // Update the fields
                $order->team_name = $request->team_name;
                $order->typography = $request->typography;
                $order->colors = $request->colors;
                // $order->logo = $request->logo;
                $order->date = $request->date;
                $order->is_in_progress = $request->is_in_progress;

                // Save it in data base
                $order->save();

                return response($order, 200);
            } else {
                $res = ['error' => 'La orden solicitada no existe.'];
                return response($res, 200);
            }
        } catch (Exception $e) {
            $res = ['error' => 'Hubo un problema con la base de datos, intentelo más tarde.'];
            return response($res, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order = Order::find($id);

            if($order) {
                $order->delete();
                return response($order, 200);
            } else {
                $res = ['error' => 'La orden solicitada no existe.'];
                return response($res, 205);
            }
        } catch (Exception $e) {
            $res = ['error' => 'Hubo un problema con la base de datos, intentelo más tarde.'];
            return response($res, 400);
        }
    }
}
