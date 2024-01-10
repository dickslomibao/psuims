<?php

namespace App\Http\Controllers;

use App\Mail\NotifyFaculty;
use App\Models\Comment;
use App\Models\Constant;
use App\Models\DeparmentEvaluator;
use App\Models\FileLogs;
use App\Models\ImDepartmentEvaluator;
use App\Models\ImDepartmentScore;
use App\Models\ImUniversityEvaluator;
use App\Models\ImUniversityScore;
use App\Models\Log;
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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use LaravelFileViewer;

class FileRepoController extends Controller
{
    public function index()
    {
        return view('faculty.index', [
            'types' => Type::all(),
        ]);
    }
    public function repo()
    {

        return view('faculty.materials.index', [
            'types' => Type::all(),
        ]);
    }

    public function  viewAddScore($id)
    {
        $file = Repo::findOrFail($id);

        $matrix = MatrixCriteriasScore::with(['subCriteria'])->where('repo_id', $id)->get();
        return view('faculty.materials.add_score', [
            'matrix' =>  $matrix,
            'file' => $file,
        ]);
    }
    public function  viewAddScoreUniversity($id)
    {
        $file = Repo::findOrFail($id);

        $matrix = MatrixCriteriasScore::with(['subCriteria'])->where('repo_id', $id)->get();
        return view('faculty.materials.university_add_score', [
            'matrix' =>  $matrix,
            'file' => $file,
        ]);
    }
    public function  viewDepartmentScore($id)
    {
        $file = Repo::findOrFail($id);


        $matrix = MatrixCriteriasScore::with(['subCriteria'])->where('repo_id', $id)->get();
        return view('faculty.materials.view_score', [
            'matrix' =>  $matrix,
            'file' => $file,
        ]);
    }
    public function  viewUniversityScore($id)
    {
        $file = Repo::findOrFail($id);


        $matrix = MatrixCriteriasScore::with(['subCriteria'])->where('repo_id', $id)->get();
        return view('faculty.materials.view_university_score', [
            'matrix' =>  $matrix,
            'file' => $file,
        ]);
    }
    public function AddDepartmentScore($id, Request $request)
    {


        $im = Repo::findOrFail($id);
        $matrix = MatrixCriteriasScore::with(['subCriteria'])->where('repo_id', $id)->get();
        foreach ($matrix as $key => $m) {
            foreach ($m->subCriteria as $sub) {
                ImDepartmentScore::create(
                    [
                        'repo_id' => $id,
                        'matrix_critertias_score_id' => $m->id,
                        'matrix_sub_critertias_score_id' => $sub->id,
                        'trial' => $im->trial,
                        'score' => $request->input($m->id . '-' . $sub->id),
                        'user_id' => Auth::user()->id,
                    ]
                );
            }
        }
        Log::create([
            'repo_id' => $id,
            'process_by' => Auth::user()->id,
            'code' => 1,
            'feedback' => $request->feedback,
            'trial' => $im->trial,
        ]);
        if ($im->getDeptUserCurrentAvgAttribute(Auth::user()->id) < 75) {
            $im->state = 2;
            $im->save();
        } else {
            if ($im->getTotalCurrentSubmittedDeptScoreAttribute() == count($im->departmentEvaluator)) {
                $im->status = 2;
                $im->save();
            }
        }
        return redirect()->route('view.repo', [
            'id' => $id,
        ]);
    }
    public function AddScoreUniversity($id, Request $request)
    {

        $im = Repo::findOrFail($id);
        $matrix = MatrixCriteriasScore::with(['subCriteria'])->where('repo_id', $id)->get();

        foreach ($matrix as $key => $m) {
            foreach ($m->subCriteria as $sub) {
                ImUniversityScore::create(
                    [
                        'repo_id' => $id,
                        'matrix_critertias_score_id' => $m->id,
                        'matrix_sub_critertias_score_id' => $sub->id,
                        'trial' => $im->u_trial,
                        'score' => $request->input($m->id . '-' . $sub->id),
                        'user_id' => Auth::user()->id,
                    ]
                );
            }
        }
        Log::create([
            'repo_id' => $id,
            'process_by' => Auth::user()->id,
            'code' => 3,
            'feedback' => $request->feedback,
            'trial' => $im->u_trial,
        ]);
        if ($im->getUeUserCurrentAvgAttribute(Auth::user()->id) < 75) {
            $im->state = 2;
            $im->save();
        } else {
            if ($im->getTotalCurrentSubmittedUniversityScoreAttribute() == count($im->universityEvaluator)) {
                $im->status = 4;
                $im->save();
            }
        }
        return redirect()->route('view.repo', [
            'id' => $id,
        ]);
    }
    public function view($id)
    {

        $file = Repo::findOrFail($id);


        $filepath = $file->path;
        $url = storage_path("app/private/{$filepath}");

        $filename =  $file->path;
        $file_url =  storage_path("app/private/" . $filepath);
        // return response()->download($file_url);
        $file_data = [
            [
                'label' => __('Label'),
                'value' => "Value"
            ]
        ];
        $excludeUserIds = DeparmentEvaluator::pluck('user_id')->toArray();

        $faculty =
            User::where('campus_id', Auth::user()->campus_id)
            ->where('college_id', Auth::user()->college_id)
            ->where('department_id', Auth::user()->department_id)
            ->where('id', '!=', Auth::user()->id)
            ->where('designation', 1)
            ->whereNotIn('id', $excludeUserIds)
            ->get();
        return view('faculty.materials.view', [
            'file' => $file,
            'url' => $url,
            'matrix' => $this->getFullMatrix(),
            'types' => Type::all(),
            'faculty' => $faculty,
        ]);
    }
    public function download($id)
    {
        $file = Repo::findOrFail($id);

        $filepath = $file->path;
        $url = storage_path("app/private/{$filepath}");

        $filename =  $file->path;
        $file_url =  storage_path("app/private/" . $filepath);

        return response()->download($file_url);
    }
    public function downloadFileLogs($id)
    {
        $file = FileLogs::findOrFail($id);

        $filepath = $file->path;
        $file_url =  storage_path("app/private/" . $filepath);

        return response()->download($file_url);
    }
    public function addComments(Request $request, $id)
    {
        $file = Repo::findOrFail($id);
        Comment::create([
            'repo_id' => $id,
            'comment' => $request->comment,
            'user_id' => Auth::user()->id,
        ]);
        Mail::to($file->faculty->email)->send(
            new NotifyFaculty(
                [
                    'comment' => $request->comment,
                ]
            ),
        );
        return redirect()->back();
    }
    public function completePlagiarism(Request $request, $id)
    {
        $file = Repo::findOrFail($id);
        $uEvaluator = User::where('designation', 4.1)->where('status', 1)->orderBy('created_at', 'DESC')->get();
        if (count($uEvaluator) >= 1) {
            Log::create([
                'repo_id' => $id,
                'process_by' => Auth::user()->id,
                'code' => 2,
                'feedback' => $request->feedback,
            ]);
            $file->status = 3;
            $file->save();
            foreach ($uEvaluator as $key => $ue) {
                ImUniversityEvaluator::create([
                    'repo_id' => $id,
                    'user_id' => $ue->id,
                ]);
            }
        }
        return redirect()->back();
    }
    public function completeVps(Request $request, $id)
    {
        $file = Repo::findOrFail($id);
        Log::create([
            'repo_id' => $id,
            'process_by' => Auth::user()->id,
            'code' => 4,
            'feedback' => $request->feedback,
        ]);
        $file->status = 5;
        $file->save();
        return redirect()->back();
    }
    public function setMatrix($repo_id, Request $request)
    {
        $file = Repo::findOrFail($repo_id);

        if ($file->matrices_id == 0) {
            $matrix = Matrix::FindOrFail($request->matrices_id);
            foreach (MatrixCriteria::where('matrices_id', $request->matrices_id)->get() as $m_c) {
                $newRecord =   MatrixCriteriasScore::create([
                    'repo_id' => $repo_id,
                    'title' => $m_c->title,
                    'percentage' => $m_c->percentage,
                    'created_by' => Auth::user()->id,
                ]);
                foreach (MatrixSubCriteria::where('matrix_criterias_id', $m_c->id)->get() as  $s_c) {
                    MatrixSubCriteriasScore::create([
                        'matrix_criterias_scores_id' =>  $newRecord->id,
                        'title' =>   $s_c->title,
                        'percentage' =>   $s_c->percentage
                    ]);
                }
            }
            $file->matrices_id = $request->matrices_id;
            $file->save();
        }

        return redirect()->route('view.repo', [
            'id' => $repo_id,
        ]);
    }

    public function getFullMatrix()
    {

        $full = [];

        $matrix = Matrix::all();

        foreach ($matrix  as $m) {
            if ($m->getTotalCriteriaPercentageAttribute() >= 100) {
                $matrix_criteria = MatrixCriteria::where('matrices_id', $m->id)->get();
                $matrix_criteria_count = MatrixCriteria::where('matrices_id', $m->id)->count();
                $full_count = 0;
                foreach ($matrix_criteria as $key => $c) {

                    if ($c->getTotalSubCriteriaPercentageAttribute() >= $c->percentage) {
                        $full_count++;
                    }
                }
                if ($full_count ==  $matrix_criteria_count) {
                    array_push($full, $m);
                }
            }
        }

        return  $full;
    }
    public function additionalDepartmentEvaluator($id, Request $request)
    {
        $file = Repo::findOrFail($id);

        ImDepartmentEvaluator::create([
            'repo_id' => $id,
            'user_id' => $request->faculty,
        ]);

        return redirect()->back();
    }
    public function getRepo()
    {
        $data = [];

        if (Auth::user()->designation == 2 || Auth::user()->designation == 1) {
            $only = ImDepartmentEvaluator::where('user_id', Auth::user()->id)->pluck('repo_id')->toArray();

            $data = Repo::with(['faculty',  't_type'])
                ->whereHas('faculty', function ($query) {
                    $query->where(function ($subQuery) {
                        $user = Auth::user();
                        $subQuery->where('department_id', $user->department_id)
                            ->where('campus_id', $user->campus_id);
                    });
                })
                ->whereIn('id', $only)
                ->get();
        }


        // if (Auth::user()->designation == 1) {
        //     $data = Repo::with(['faculty', 't_type'])->where('user_id', Auth::user()->id)->get();
        // }

        // if (Auth::user()->designation == 4.2) {
        //     $temp = Repo::with(['faculty', 't_type'])->get();
        //     foreach ($temp as $value) {
        //         if ($value->faculty->department_id == Auth::user()->department_id || $value->faculty->campus_id == Auth::user()->campus_id) {
        //             array_push($data, $value);
        //         }
        //     }
        // }

        if (Auth::user()->designation == 3) {
            $data = Repo::with(['faculty',  't_type'])->get();
        }

        if (Auth::user()->designation == 4.1) {

            $only = ImUniversityEvaluator::where('user_id', Auth::user()->id)->pluck('repo_id')->toArray();
            $data = Repo::with(['faculty',  't_type'])
                ->whereIn('id', $only)
                ->get();
        }
        if (Auth::user()->designation == 5) {
            $data = Repo::with(['faculty', 'fileLogs', 't_type'])->get();
        }

        if (Auth::user()->type == 2) {
            $data = Repo::with(['faculty', 'fileLogs', 't_type'])->get();
        }
        return response()->json($data);
    }

    public function upload(Request $request)
    {
        $file = $request->file;
        $path = Storage::putFile('private', $request->file('file'));
        Repo::create([
            'title' => $request->title,
            'type' => $request->type,
            'user_id' => auth()->user()->id,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
        ]);
        return redirect()->back();
    }

    public function updateRepo($id, Request $request)
    {

        $file = Repo::findOrFail($id);

        $file->title = $request->title;
        $file->type = $request->type;

        if ($request->exists('file')) {
            $f = $request->file;
            $path = Storage::putFile('private', $request->file('file'));
            $file->original_name = $f->getClientOriginalName();
            $file->path = $path;
        }
        $file->save();
        return redirect()->back();
    }
}
