<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Http\Requests\RolePermissionRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;
use App\Repositories\RbacRepository;

class RbacController extends Controller
{
    public function __construct(public RbacRepository $rbacRepository)
    {
        $this->rbacRepository = $rbacRepository;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $data = $this->rbacRepository->index();
        return ApiResponseClass::sendResponse(RoleResource::collection($data),'',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request) : JsonResponse
    {
        try{
            DB::beginTransaction();
            $campaign = $this->rbacRepository->store($request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse(new RoleResource($campaign),'Role Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id) : JsonResponse
    {
        $campaign = $this->rbacRepository->getById($id);
        return ApiResponseClass::sendResponse(new RoleResource($campaign),'',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $result = $this->rbacRepository->update($request->validated(), $id);
            DB::commit();
            return ApiResponseClass::sendResponse(new RoleResource($result), 'Role updated successfully', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : JsonResponse
    {
        $this->rbacRepository->delete($id);
        return ApiResponseClass::sendResponse('', 'Role Delete Successful', 204);
    }

    public function update_role_permission(RolePermissionRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = $this->rbacRepository->update_role_permission($request->validated());
            DB::commit();
            return ApiResponseClass::sendResponse($result, 'Role Permission Updated Successfully', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }
}
