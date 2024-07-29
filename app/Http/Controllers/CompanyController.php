<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$companies = Company::all();
        // dd($companies); //check of de data goed binnen komt, voordat de view toegeveogd

        if (Auth::check()){

            $companies= Company::where('user_id', Auth::user()->id)->get();
            return view('companies.index', ['companies' => $companies]);

        }
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check()) { //nogmaals check of iemand geautoriseerd is om naar de db te schrijven
             
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string'
            ]);
            $company = Company::create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'user_id' => Auth::id()
            ]);

           // echo ($company->user_id);

            // if ($company) {
            //     $company->save();
            // }

            if ($company) {
                return redirect()->route('company.index')
                    ->with('success', 'Company updated successfull '); //success hangt weer samen met de alert in succes.blade.php
            } else {
                return back()->withInput()->with('errors', 'ERROR: Check formulier'); //withInput wat je gezijzijgsd heb stuutrt hij mee
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('companies.show', ['company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]); // als dit niet voldoet wordt $errors geset ( zie errro.blade.php)


        $companyUpdate = $company->update($request->toArray());

        if ($companyUpdate) {
            return redirect()->route('company.show', ['company' => $company->id])
                ->with('success', 'Company updated successfull '); //success hangt weer samen met de alert in succes.blade.php
        } else {
            return back()->withInput()->with('errors', 'ERROR: Check formulier'); //withInput wat je gezijzijgsd heb stuutrt hij mee
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if (Auth::id() === $company->user_id) {

            if ($company->delete()) {
                return redirect()->route('company.index')
                    ->with('success', 'Company deleted successfully');
            }
        }
        return back()->withInput()->with('error', 'Company could not be deleted');
    }

    public function adduser()
    {
        
    }
}
