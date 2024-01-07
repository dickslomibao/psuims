<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matrix;
use App\Models\MatrixCriteria;
use App\Models\MatrixSubCriteria;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;


class MatrixController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:2');
    }
    public function index()
    {
        return view('admin.matrix.index');
    }

    public function viewMatrix($id)
    {
        $matrix = Matrix::FindOrFail($id);

        return view('admin.matrix.view', [
            'matrix' => $matrix,
            'percentage' => $this->totalCriteriaPercent($id),
        ]);
    }
    public  function totalCriteriaPercent($matrix_id)
    {
        return MatrixCriteria::where('matrices_id', $matrix_id)->sum('percentage');
    }

    public  function totalSubCriteriaPercent($matrix_criteria_id)
    {
        return MatrixSubCriteria::where('matrix_criterias_id', $matrix_criteria_id)->sum('percentage');
    }
    public function viewMatrixSubCriteria($matrix_id, $matrix_criteria_id)
    {

        $matrix = Matrix::FindOrFail($matrix_id);

        $matrix_citeria = MatrixCriteria::FindOrFail($matrix_criteria_id);

        return view('admin.matrix.view_criteria', [
            'matrix' => $matrix,
            'matrix_citeria' => $matrix_citeria,
            'percentage' => $this->totalSubCriteriaPercent($matrix_criteria_id),
        ]);
    }
    public function addMatrix(Request $request)
    {
        $code = 200;
        $message = 'Added Successfully';
        try {
            Matrix::create(
                [
                    'title' => $request->title,
                ]
            );
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
    public function addMatrixCiteria($id, Request $request)
    {
        $code = 200;
        $message = 'Added Successfully';
        try {
            MatrixCriteria::create(
                [
                    'matrices_id' => $id,
                    'title' => $request->title,
                    'percentage' => $request->percentage,
                ]
            );
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
    public function addMatrixSubCriteria($matrix_id, $matrix_criteria_id, Request $request)
    {
        $code = 200;
        $message = 'Added Successfully';
        try {
            MatrixSubCriteria::create(
                [
                    'matrix_criterias_id' => $matrix_criteria_id,
                    'title' => $request->title,
                    'percentage' => $request->percentage,
                ]
            );
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
    public function getMatrix()
    {
        return response()->json(Matrix::all());
    }

    public function getMetrixCriteria($id)
    {
        $matrices = MatrixCriteria::where('matrices_id', $id)->get();
        $matrices->each(function ($matrix) {
            $matrix->total_sub_criteria_percentage = $matrix->getTotalSubCriteriaPercentageAttribute();
        });
        return response()->json($matrices);
    }
    public function getMetrixSubCriteria($matrix_id, $matrix_criteria_id)
    {
        return response()->json(MatrixSubCriteria::where('matrix_criterias_id', $matrix_criteria_id)->get());
    }
}
