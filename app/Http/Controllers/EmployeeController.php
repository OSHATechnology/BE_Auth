<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    const VALIDATION_RULES = [
        'firstName' => 'required|string|min:3|max:15',
        'lastName' => 'required|string|min:3|max:15',
        'birthDate' => 'required|date',
        'phone' => 'required|string|min:10|max:13',
        'email' => 'required|email|unique:employees|max:255',
        'password' => 'required|string|min:6|max:24',
        'gender' => 'required|string|max:255',
        'address' => 'required|string|min:6|max:50',
        'city' => 'required|string|min:3|max:30',
        'nation' => 'required|string|min:3|max:30',
        'roleId' => 'required|integer',
        'isActive' => 'required|boolean',
        'emailVerifiedAt' => 'date',
        'joinedAt' => 'required|date',
        'resignedAt' => 'date',
        'statusHireId' => 'required|boolean'
    ];

    const MessageError = [
        'firstName.required' => 'Nama depan tidak boleh kosong',
        'firstName.min' => 'Nama depan minimal 3 karakter',
        'firstName.max' => 'Nama depan maksimal 15',
        'lastName.required' => 'Nama akhir tidak boleh kosong',
        'lastName.min' => 'Nama akhir minimal 3 karakter',
        'lastName.max' => 'Nama akhir maksimal 15',
        'birthDate.required' => 'Tanggal lahir tidak boleh kosong',
        'phone.required' => 'Nomor Telepon tidak boleh kosong',
        'phone.min' => 'Nomor Telepon minimal 10 karakter',
        'phone.max' => 'Nomor Telepon tidak boleh lebih dari 13 karakter',
        'email.required' => 'Email tidak boleh kosong',
        'email.email' => 'format email tidak sesuai',
        'password.required' => 'password tidak boleh kosong',
        'password.min' => 'password minimal 6 karakter',
        'password.max' => 'password maksimal 24 karakter',
        'gender.required' => 'gender tidak boleh kosong',
        'address.required' => 'address tidak boleh kosong',
        'address.min' => 'address minimal 6 karakter',
        'address.max' => 'address maksimal 50 karakter',
        'city.required' => 'city tidak boleh kosong',
        'city.min' => 'city minimal 3 karakter',
        'city.max' => 'city maksimal 30 karakter',
        'nation.required' => 'nation tidak boleh kosong',
        'nation.min' => 'nation minimal 3 karakter',
        'nation.max' => 'nation maksimal 30 karakter',
        'roleId.required' => 'role tidak boleh kosong',
        'joinedAt.required' => 'joinedAt tidak boleh kosong',
    ];

    const numPaginate = 10;
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
        try {
            $this->validate($request, self::VALIDATION_RULES, self::MessageError);
            $employee = new Employee;
            $employee->firstName = $request->firstName;
            $employee->lastName = $request->lastName;
            $employee->phone = $request->phone;
            $employee->email = $request->email;
            $employee->password = bcrypt($request->password);
            if ($request->hasFile('photo')) {
                $imageName = time() . '.' . $request->photo->extension();
                $path = $request->file('photo')->storeAs('public/employee_image', $imageName);
                $employee->photo = 'storage/employee_image/' . $imageName;
            } else {
                $employee->photo = $request->photo;
            }

            $employee->gender = $request->gender;
            $employee->birthDate = $request->birthDate;
            $employee->address = $request->address;
            $employee->city = $request->city;
            $employee->nation = $request->nation;
            $employee->roleId = $request->roleId;
            $employee->isActive = $request->isActive;
            $employee->emailVerifiedAt = $request->emailVerifiedAt;
            $employee->remember_token = $request->remember_token;
            $employee->joinedAt = $request->joinedAt;
            $employee->resignedAt = $request->resignedAt;
            $employee->statusHireId = $request->statusHireId;
            $employee->save();
            return $this->sendResponse(new EmployeeResource($employee), "employee created successfully");
        } catch (\Throwable $th) {
            return $this->sendError("failed creating employee", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
