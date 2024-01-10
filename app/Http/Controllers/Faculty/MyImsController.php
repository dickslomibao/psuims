<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\DeparmentEvaluator;
use App\Models\FileLogs;
use App\Models\ImDepartmentEvaluator;
use App\Models\Matrix;
use App\Models\MatrixCriteria;
use App\Models\MatrixCriteriasScore;
use App\Models\MatrixSubCriteria;
use App\Models\MatrixSubCriteriasScore;
use App\Models\Repo;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MyImsController extends Controller
{
    public function index()
    {

        return view('faculty.my_ims.index', [
            'types' => Type::all(),
        ]);
    }
    public function view($id)
    {
        $excludeUserIds = DeparmentEvaluator::pluck('user_id')->toArray();
        $faculty =
            User::where('campus_id', Auth::user()->campus_id)
            ->where('college_id', Auth::user()->college_id)
            ->where('department_id', Auth::user()->department_id)
            ->where('id', '!=', Auth::user()->id)
            ->where('designation', 1)
            ->whereNotIn('id', $excludeUserIds)
            ->get();
        $file = Repo::findOrFail($id);
        $filepath = $file->path;
        $url = storage_path("app/private/{$filepath}");
        $filename =  $file->path;
        $file_url =  storage_path("app/private/" . $filepath);
        $file_data = [
            [
                'label' => __('Label'),
                'value' => "Value"
            ]
        ];
        return view('faculty.my_ims.view', [
            'file' => $file,
            'url' => $url,
            'types' => Type::all(),
            'faculty' => $faculty,
        ]);
    }
    public static  function setImMatrix($repo_id)
    {
        $file = Repo::findOrFail($repo_id);

        if ($file->matrices_id == 0) {
            $matrix = Matrix::FindOrFail(Matrix::where('status', 1)->first()->id);
            foreach (MatrixCriteria::where('matrices_id',  $matrix->id)->get() as $m_c) {
                $newRecord =   MatrixCriteriasScore::create([
                    'repo_id' => $repo_id,
                    'title' => $m_c->title,
                    'percentage' => $m_c->percentage,
                    'created_by' => 'auto',
                ]);
                foreach (MatrixSubCriteria::where('matrix_criterias_id', $m_c->id)->get() as  $s_c) {
                    MatrixSubCriteriasScore::create([
                        'matrix_criterias_scores_id' =>  $newRecord->id,
                        'title' =>   $s_c->title,
                        'percentage' =>   $s_c->percentage
                    ]);
                }
            }
            $file->matrices_id =  $matrix->id;
            $file->save();
        }
    }
    public function getMyIms()
    {
        $data = Repo::with(['faculty', 't_type'])->where('user_id', Auth::user()->id)->get();
        return response()->json($data);
    }

    public function upload(Request $request)
    {
        $file = $request->file;
        $path = Storage::putFile('private', $request->file('file'));
        $repo = Repo::create([
            'title' => $request->title,
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
        ]);
        if ($repo) {
            $chair = User::where('campus_id', Auth::user()->campus_id)
                ->where('college_id', Auth::user()->college_id)
                ->where('department_id', Auth::user()->department_id)
                ->where('designation', 2)->first();
            if ($chair) {
                $data = [];
                if ($chair->id != Auth::user()->id) {
                    array_push($data, [
                        'repo_id' => $repo->id,
                        'user_id' => $chair->id,
                    ]);
                }

                $evaluator =
                    DeparmentEvaluator::where('campus_id', Auth::user()->campus_id)
                    ->where('college_id', Auth::user()->college_id)
                    ->where('department_id', Auth::user()->department_id)->get();

                foreach ($evaluator as $key => $e) {
                    if (Auth::user()->id != $e->user_id) {
                        array_push(
                            $data,
                            [
                                'repo_id' => $repo->id,
                                'user_id' => $e->user_id,
                            ]
                        );
                    }
                }
                ImDepartmentEvaluator::insert($data);
                $this->setImMatrix($repo->id);
            }
        }
        return redirect()->back();
    }

    public function reuploadIms($id, Request $request)
    {

        $file = Repo::findOrFail($id);

        if ($request->exists('file')) {
            $f = $request->file;
            $path = Storage::putFile('private', $request->file('file'));
            FileLogs::create([
                'repo_id' => $id,
                'path' => $file->path,
                'filaname' =>   $file->original_name,
                'code' => $file->status,
            ]);
            $file->original_name = $f->getClientOriginalName();
            $file->path = $path;
            $file->state = 1;
            if ($file->status == 3) {
                $file->u_trial = $file->u_trial + 1;
            }
            if ($file->status == 1) {
                $file->trial = $file->trial + 1;
            }
        }
        $file->save();
        return redirect()->back();
    }
}
