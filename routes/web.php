<?php

use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\Admin\CollegeControler;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\MatrixController;
use App\Http\Controllers\FileRepoController;
use App\Http\Controllers\ProfileController;
use App\Models\Campuse;
use App\Models\College;
use App\Models\Department;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    });
    Route::controller(CampusController::class)->group(function () {
        Route::get('/campuses', 'index')->name('index.campus');
        Route::POST('/campuses', 'retrieve')->name('retrieve.campus');
        Route::post('/campuses/store', 'store')->name('store.campus');
    });
    Route::controller(CollegeControler::class)->group(function () {
        Route::get('/college', 'index')->name('index.college');
        Route::POST('/college', 'retrieve')->name('retrieve.college');
        Route::post('/college/store', 'store')->name('store.college');
    });

    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/department', 'index')->name('index.department');
        Route::POST('/department', 'retrieve')->name('retrieve.department');
        Route::POST('/reg/getdepartment', function (Request $request) {
            return response()->json(Department::where('college_id', $request->id)->get());
        })->name('college.department');
        Route::post('/department/store', 'store')->name('store.department');
    });

    Route::controller(MatrixController::class)->group(function () {
        Route::get('/matrix', 'index')->name('index.matrix');
        Route::get('/matrix/{id}/view', 'viewMatrix')->name('view.matrix');
        Route::get('/matrix/{matrix_id}/view/matix_criteria/{matrix_criteria_id}/view', 'viewMatrixSubCriteria')->name('view.sub_matrix_criteria');
        Route::POST('/matrix/{matrix_id}/view/matix_criteria/{matrix_criteria_id}/view', 'getMetrixSubCriteria')->name('get.sub_matrix_criteria');
        Route::POST('/matrix/{matrix_id}/view/matix_criteria/{matrix_criteria_id}/add', 'addMatrixSubCriteria')->name('add.matrix_sub_criteria');
        Route::POST('/matrix', 'getMatrix')->name('get.matrix');
        Route::POST('/matrixa/add', 'addMatrix')->name('add.matrix');
        Route::POST('/matrix/{id}/view/criteria', 'getMetrixCriteria')->name('view.matrix');
        Route::POST('/matrix/{id}/view/criteria/add', 'addMatrixCiteria')->name('add.matrix_criteria');
    });
});
Route::prefix('file')->group(function () {
    Route::controller(FileRepoController::class)->group(function () {
        Route::get('/', 'index')->name('index.file');
        Route::get('/repository', 'repo')->name('index.repo');
        Route::get('/repository/{id}/details', 'view')->name('view.repo');
        Route::POST('/repository/{id}/addcomment', 'addComments')->name('comment.repo');
        Route::POST('/repository/{id}/plagirism', 'completePlagiarism')->name('plagiarism.repo');
        Route::POST('/repository/{id}/setMatrix', 'setMatrix')->name('set_matrix.repo');
        Route::get('/repository/{id}/viewAddScore', 'viewAddScore')->name('view_add_score.repo');
        Route::get('/repository/{id}/viewAddScore/university', 'viewAddScoreUniversity')->name('view_add_score.repo');
        Route::POST('/repository/{id}/viewAddScore/university', 'updateScoreUniversity');
        Route::get('/repository/{id}/download', 'download')->name('download.repo');
        Route::POST('/repository/{id}/update', 'updateRepo')->name('update.repo');
        Route::POST('/repository/{id}/completeVps', 'completeVps')->name('vps.repo');
        Route::get('/repository/{id}/viewScoreOnly', 'viewScore')->name('view_score.repo');
        Route::POST('/repository/{id}/viewAddScore', 'updateScore')->name('update_score.repo');
        Route::POST('/repository', 'getRepo')->name('get.repo');
        Route::POST('/repository/store', 'upload')->name('upload.repo');
    });
});


Route::get('/init', function () {
    Campuse::create([
        'name' => 'Urdeneta City Campus',
        'address' => 'Urdaneta City, Pangasinan'
    ]);
    Campuse::create([
        'name' => 'Bayambang Campus',
        'address' => 'Bayambang, Pangasinan'
    ]);

    Campuse::create([
        'name' => 'Santa Maria Campus',
        'address' => 'Santa Maria, Pangasinan'
    ]);

    College::create([
        'name' => 'College of computing'
    ]);
    College::create([
        'name' => 'College of engineering'
    ]);
    Department::create(
        [
            'college_id' => 1,
            'name' => 'Information Technology'
        ]
    );
    Department::create(
        [
            'college_id' => 2,
            'name' => 'Civil engineering'
        ]
    );
    Type::create([
        'name' => 'Course book',
    ]);
    Type::create([
        'name' => 'Textbook',
    ]);
    Type::create([
        'name' => 'Course book',
    ]);
    Type::create([
        'name' => 'Modules',
    ]);
    Type::create([
        'name' => 'Laboratory manual',
    ]);
    Type::create([
        'name' => 'Prototype',
    ]);
    User::create([
        'campus_id' => 0,
        'college_id' => 0,
        'department_id' => 0,
        'designation' => '4.2',
        'profile_image' =>  'storage/public/miimRWzVuSaai9X13mtTVgueTbQZylASfHMYhe3h.jpg',
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('123123123'),
        'type' => 2,
    ]);
    User::create([
        'campus_id' => 1,
        'college_id' => 1,
        'department_id' => 1,
        'designation' => '4.2',
        'profile_image' =>  'storage/public/miimRWzVuSaai9X13mtTVgueTbQZylASfHMYhe3h.jpg',
        'name' => 'Testing (evaluator)',
        'email' => 'eval123@gmail.com',
        'password' => Hash::make('123123123'),

    ]);
    User::create([
        'campus_id' => 1,
        'college_id' => 1,
        'department_id' => 1,
        'designation' => '1',
        'profile_image' =>  'storage/public/miimRWzVuSaai9X13mtTVgueTbQZylASfHMYhe3h.jpg',
        'name' => 'Dick Lomibao (faculty)',
        'email' => 'dick@gmail.com',
        'password' => Hash::make('123123123'),
    ]);
});
Route::get('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
});
Route::get('/', function (Request $request) {

    if (Auth::user()->type == 2) {
        return redirect('/admin');
    } else {
        return redirect('/file');
    }
})->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
