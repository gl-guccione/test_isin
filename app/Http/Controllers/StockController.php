<?php

// defining Namespace
namespace App\Http\Controllers;

// using Laravel Facades
use Illuminate\Http\Request;

// using Faker
use  Faker\Generator as Faker;

// using Carbon
use Carbon\Carbon;

// using Writer
use League\Csv\Writer;

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

        $today = Carbon::today();

        $data = [
          'stocks' => $stocks,
          'today' => $today
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
        $newStock->isin = strtoupper($data['isin']);
        $newStock->date_of_start = $data['date_of_start'];
        $newStock->date_of_end = $data['date_of_end'];

        $newStock->save();

        return redirect()->route('stocks.index');
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

    /**
     * Create a csv file that contain all the data inside the database.
     *
     * @return csv file
     */
    public function exportCsv() {

      $stocks = Stock::all();

      if (count($stocks)) {

        // removing created_at and updated_at columns
        foreach ($stocks as $stock) {
          unset($stock->created_at);
          unset($stock->updated_at);
        }

        $fileCsv = Writer::createFromFileObject(new \SplTempFileObject);

        $fileCsv->insertOne(array_keys($stocks[0]->getAttributes()));

        foreach ($stocks as $stock) {
          $fileCsv->insertOne($stock->toArray());
        }

        $fileCsv->output('stocks.csv');

      } else {

        return redirect()->back()->withErrors('empty csv');

      }

    }


    /**
     * Create and insert a random stock.
     */
    public function randomStock(Faker $faker) {

      $new_stock = new Stock;

      do {
        $isin = $faker->countryCode().$faker->regexify('[0-9]{10}');
      } while (count(Stock::where('isin', $isin)->get()));

      $new_stock->name = $faker->company();
      $new_stock->isin = $isin;
      $new_stock->date_of_start = $faker->dateTimeBetween('-1 week', '+1 week');
      $new_stock->date_of_end = Carbon::parse($new_stock->date_of_start)->addDays(rand(1, 7));

      $new_stock->save();

      return redirect()->back();

    }
}
