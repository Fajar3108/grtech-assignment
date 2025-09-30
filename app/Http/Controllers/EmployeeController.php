<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Notifications\NewEmployeeAdded;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Employee/Index', [
            'employees' => Employee::with('company')->latest()->paginate(10),
            'companies' => Company::select(['id', 'name'])->latest()->get()->map(function ($company) {
                return [
                    'label' => $company->name,
                    'value' => $company->id,
                ];
            }),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Employee/Create', [
            'companies' => Company::select(['id', 'name'])->latest()->get()->map(function ($company) {
                return [
                    'label' => $company->name,
                    'value' => $company->id,
                ];
            }),
        ]);
    }

    public function store(EmployeeRequest $request): RedirectResponse
    {
        $employee = Employee::create($request->all());

        $employee->company->notify(new NewEmployeeAdded($employee));

        return Redirect::route('employee.index')->with('success', 'Employee created successfully');
    }

    public function update(Employee $employee, EmployeeRequest $request): RedirectResponse
    {
        $employee->update($request->all());
        return Redirect::back()->with('success', 'Employee updated successfuly');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();
        return Redirect::back()->with('success', 'Employee deleted successfuly');
    }
}
