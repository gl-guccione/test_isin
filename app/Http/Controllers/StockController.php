<?php

// defining Namespace
namespace App\Http\Controllers;

// using Laravel Facades
use Illuminate\Http\Request;

// unsing Models
use App\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all();

        $data = [
          'stocks' => $stocks
        ];

        return view('home', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
          'name' => ['required', 'string', 'between:3,50'],
          'isin' => ['required', 'string', 'unique:stocks', 'size:12', 'regex:/([a-zA-Z]{2})([0-9]{10})/'],
          'date_of_start' => ['required', 'date'],
          'date_of_end' => ['required', 'date', 'after:date_of_start']
        ]);

        $newStock = new Stock;

        $newStock->name = $data['name'];
        $newStock->isin = $data['isin'];
        $newStock->date_of_start = $data['date_of_start'];
        $newStock->date_of_end = $data['date_of_end'];

        $newStock->save();

        return redirect()->route('stocks.index');
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
        $stock = Stock::find($id);

        $stock->delete();

        return redirect()->route('stocks.index');
    }
}
