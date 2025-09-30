<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Company/Index', [
            'companies' => Company::latest()->paginate(10),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Company/Create');
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        $data = $request->except('logo');

        if ($request->has('logo') && isset($request->logo[0]['originFileObj'])) {
            $file = $request->logo[0]['originFileObj'];
            $path = $file->store('company_logos', 'public');
            $data['logo'] = $path;
        }

        Company::create($data);

        return Redirect::route('company.index')->with('success', 'Company created successfully');
    }

    public function update(Company $company, CompanyRequest $request): RedirectResponse
    {
        $data = $request->except('logo');

        $isExistInStorage = isset($company->logo) && Storage::disk('public')->exists($company->logo);

        if ($isExistInStorage && count($request->logo) == 0) {
            Storage::disk('public')->delete($company->logo);
            $data['logo'] = '';
        } else if ($request->has('logo') && isset($request->logo[0]['originFileObj']) && !str_contains($company->logo, $request->logo[0]['name'])) {
            if ($isExistInStorage) {
                Storage::disk('public')->delete($company->logo);
            }

            $file = $request->logo[0]['originFileObj'];
            $path = $file->store('company_logos', 'public');
            $data['logo'] = $path;
        }



        $company->update($data);
        return Redirect::back()->with('success', 'Company updated successfuly');
    }

    public function destroy(Company $company): RedirectResponse
    {
        if (isset($company->logo) && Storage::disk('public')->exists($company->logo)) {
            Storage::disk('public')->delete($company->logo);
        }
        $company->delete();
        return Redirect::back()->with('success', 'Company deleted successfuly');
    }
}
