<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $companies = Company::with('user', 'city')->orderBy('id', 'desc')->get();
        return response()->json($companies, 200);
    }

    public function changeActive($id): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $company = Company::find($id);
            $company->status = '1';
            $company->save();
            DB::commit();
            return response()->json(['message' => 'Thay đổi trạng thái thành công'], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Thay đổi trạng thái không thành công'], 500);
        }
    }

    public function changeUnActive($id): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $company = Company::find($id);
            $company->status = NULL;
            $company->save();
            DB::commit();
            return response()->json(['message' => 'Thay đổi trạng thái thành công'], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => 'Thay đổi trạng thái không thành công'], 500);
        }
    }
}
