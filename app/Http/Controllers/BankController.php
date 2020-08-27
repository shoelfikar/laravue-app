<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $bank = Bank::all();
       return response()->json($bank, 200);
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
        $request->validate([
            'bank_name' => 'required|min:3',
            'email' => 'required|email|unique:banks,contact_email',
            'logo' => 'required|image|mimes:jpg,png'
        ]);
       $bank = new Bank();
       $bank->bank_name = $request->bank_name;
       $bank->contact_email = $request->email;
       $path = $request->file('logo')->store('logo_images');
       $bank->logo = $path;

       if($bank->save()) {
           return response()->json($bank, 200);
       } else {
           return response()->json($bank, 500);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'bank_name' => 'required|min:3',
            'email' => 'required|email'
        ]);
        
        if($request->email !== $bank->contact_email) {
            $bank->contact_email = $request->email;
        }
        
        $bank->bank_name = $request->bank_name;
        $oldPath = $bank->logo;
        if ($request->hasFile('logo')) {
            $request->validate([
                'logo' => 'required|image|mimes:jpg,png'
            ]);

            $path = $request->file('logo')->store('logo_images');
            $bank->logo = $path;
        }

        if ($bank->save()) {
            return response()->json($bank, 200);
        }else {
            Storage::delete($path);
            return response()->json([
                'message'=> 'Some error accurred, Please try again!',
                'status_code'=> 500
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        if (Bank::destroy($bank->id)) {
            // Storage::delete($bank->logo);

            return response()->json([
                'message'=> 'Data Bank delete successfully!',
                'status_code'=> 200
            ], 200);
        }else {
            return response()->json([
                'message'=> 'Some error accurred, Please try again!',
                'status_code'=> 500
            ], 500);
        }
    }
}
