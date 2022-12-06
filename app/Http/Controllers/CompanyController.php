<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Validator\CompanyValidator;
use Illuminate\Support\Facades\Storage;



class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Company::paginate(10);
        // return 'Done';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = (new CompanyValidator)->validate(
            $company = new Company(),
            $request->all()
        );

        if ($request->file('logo')) {
            $path = $request->file('logo')->store('/public/images');
            $attributes['logo'] = $path;
        }

        Company::create($attributes);
        return response()->json([
            'success' => 'Company created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return response()->json([
            'success' => true,
            'data' => $company
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $attributes = (new CompanyValidator())->validate($company, $request->all());

        if ($request->file('logo')) {
            Storage::delete($company->logo);

            $path = $request->file('logo')->store('/public/images');
            $attributes['logo'] = $path;
        }

        $company->update($attributes);
        return response()->json([
            'success' => 'Company updated successfully'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if ($company->logo) {
            Storage::delete($company->logo);
        }
        $company->delete();
        return response()->json([
           'success' => 'Company deleted successfully'
        ], 200);
    }
}
