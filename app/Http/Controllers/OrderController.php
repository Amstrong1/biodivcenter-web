<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('App/Order/Index', [
            'orders' => Order::where('id', '>', 1)->get(),
            'csrf' => csrf_token(),
            'my_actions' => $this->orderActions(),
            'my_attributes' => $this->orderColumns(),
            'my_fields' => $this->orderFields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name'], '_');
        try {
            $order = new Order();
            $order->create($data);
            return back();
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return Inertia::render('App/Order/Edit', [
            'order' => $order,
            'csrf' => csrf_token(),
            'my_fields' => $this->orderFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $order->update($request->validated());
            return redirect('/orders');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            $order = $order->delete();
            return redirect('/orders');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    private function orderColumns()
    {
        $columns = [
            'name' => 'Libellé',
        ];
        return $columns;
    }

    private function orderActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function orderFields()
    {
        $fields = [
            'name' => [
                'title' => "Ordre",
                'placeholder' => '',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
            ],
        ];
        return $fields;
    }
}
