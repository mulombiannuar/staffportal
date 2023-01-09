<?php

namespace App\Http\Controllers\Records;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        //
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
        //
    }

    public function loanProducts()
    {
        // $data = $this->getCSVFileArrayValues('products.csv')['rows'];
        // for ($s=0; $s <count($data) ; $s++) { 
        //     DB::table('loan_products')->insert([
        //         'product_code' => $data[$s][0],
        //         'product_name' => $data[$s][1],
        //         'product_class_id' => $data[$s][2],
        //         'created_by' => Auth::user()->id,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
        // } 

        $pageData = [
			'page_name' => 'records',
            'title' => 'Loan Products',
            'products' => Admin::getLoanProducts()
        ];
        return view('records.clients.loan_products', $pageData);
    }

    private function getCSVFileArrayValues($fileName)
    {
        $file = asset('assets/docs/'.$fileName);
        $csvData = file_get_contents($file);
        $rows = array_map("str_getcsv", explode("\n", $csvData));
        $headers = array_shift($rows);
        return [
            'headers' => $headers,
            'rows' => $rows
        ];
    }
}
