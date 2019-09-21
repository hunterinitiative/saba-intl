<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Exceptions\AdminAlreadyExistsException;
use App\Http\Requests\StoreAdmin;
use App\User;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
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
     * @param  \App\Http\Requests\StoreAdmin  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdmin $request)
    {
        $this->authorize('modify', Admin::class);
        
        try {
            User::find($request->user_id)
                ->makeAdmin($request->is_super_admin ?? 0);
        } catch (AdminAlreadyExistsException $e) {
            throw new AdminAlreadyExistsException($e->getMessage(), 403, $e);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 403, $e);
        }
        

        return redirect()->route('admins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
