@if (Auth::user()->type == 2)
    @include('admin.includes.header', ['title' => 'Instructional Material details'])
@else
    @include('faculty.includes.header', ['title' => 'Instructional Material details'])
@endif
<div class="container-fluid" style="padding: 20px;margin-top:70px">
    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 style="margin-bottom: 5px;font-size:18px">Title: {{ $file->title }}</h6>
                    <h6 style="margin-bottom: 10px;font-size:18px">
                        Type: {{ $file->t_type->name }}</h6>
                </div>
                <div class="dropdown">
                    <i class="far fa-ellipsis-v" style="font-size: 21px" data-bs-toggle="dropdown"
                        aria-expanded="false"></i>
                    <ul class="dropdown-menu">

                        <li><a href="{{ route('view_score_department.repo', [
                            'id' => $file->id,
                        ]) }}  "
                                class="dropdown-item">Department
                                Score</a></li>

                        <li><a href="{{ route('view_score_university.repo', [
                            'id' => $file->id,
                        ]) }}  "
                                class="dropdown-item">University
                                Score</a></li>


                        <li><a class="dropdown-item" role="button" data-bs-toggle="modal"
                                data-bs-target="#updateInfo">Update Material</a></li>
                        <li><a role="button" data-bs-toggle="modal" data-bs-target="#fileLogs"
                                class="dropdown-item">File logs</a></li>

                    </ul>
                </div>
            </div>
            <div class="" style="margin-bottom:15px;">
                <h6 style="line-height: 25px;font-size:17px">Status: @switch($file->status)
                        @case(1)
                            Under Department Review
                        @break

                        @case(2)
                            Under Plagiarism Check
                        @break

                        @case(3)
                            Under University evaluation
                        @break

                        @case(4)
                            Under VPs
                        @break

                        @case(5)
                            Approved
                        @break

                        @default
                    @endswitch
                </h6>
                @if ($file->status == 1 && $file->state == 2)
                    <h6 style="color: red">Trial {{ $file->trial }} failed. Re-upload now. </h6>
                @endif
                @if ($file->status == 3 && $file->state == 2)
                    <h6 style="color: red">Trial {{ $file->u_trial }} failed. Waiting for new re-upload</h6>
                @endif
            </div>
            <h6>Faculty</h6>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center justify-content-start" style="margin-top: 15px;gap:8px">
                    <div>
                        <img src="/{{ $file->faculty->profile_image }}" style="object-fit: cover;border-radius:50%"
                            width="40" height="40" alt="">
                    </div>
                    <div>
                        <h6>{{ $file->faculty->name }}</h6>
                        <p style="font-size: 14px;font-weight:500">{{ $file->faculty->email }}</p>
                    </div>
                </div>

            </div>
            <div style="margin:20px 0;width: 100%;height:1px;background:rgba(0, 0, 0, .05)">
            </div>
            <h6 style="line-height: 25px">File name: {{ $file->original_name }}</h6>
            <h6 style="line-height: 25px">Date Uploaded: {{ $file->created_at }}</h6>
            <h6 style="line-height: 25px">Date last Updated: {{ $file->updated_at }}</h6>

            <div class="row mt-3">
                <div class="d-flex" style="gap:10px">
                    @if (\App\Classes\InstructionalMaterialClass::totalDepartmentEvaluator() != count($file->departmentEvaluator))
                        @if (Auth::user()->designation == 2)
                            <div id="modal_btn" data-bs-toggle="modal" data-bs-target="#modalDepartmentEvaluator"
                                style="flex-grow:1; cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Assigned more Evaluator
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="modalDepartmentEvaluator" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Additional department
                                                Evaluator</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('addmorede.repo', [
                                                    'id' => $file->id,
                                                ]) }}"
                                                method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        @foreach ($faculty as $f)
                                                            <div class="mb-3 d-flex align-items-center justify-content-between"
                                                                style="gap:10px">

                                                                <div class="d-flex align-items-center justify-content-start"
                                                                    style="gap:10px">
                                                                    <img src="/{{ $f->profile_image }}" alt=""
                                                                        srcset=""
                                                                        style="width: 45px;height:45px;border-radius:50%;object-fit: cover">
                                                                    <div>
                                                                        <h6>{{ $f->name }}</h6>
                                                                        <p style="font-weight: 500;font-size:15px">
                                                                            {{ $f->email }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="{{ $f->id }}" name="faculty"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100"
                                                    style="border:none;background: var(--primaryBG)">Add</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @else
                            <div id="modal_btn"
                                style="flex-grow:1; cursor:pointer;border-radius:5px;background: red;font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Waiting for chair to assign additional Department evaluator
                            </div>
                        @endif
                    @else
                        <div onClick="location.href='/instructionalmaterials/evaluate/{{ $file->id }}/download';"
                            style="flex-grow:1; cursor:pointer;border-radius:5px;background: forestgreen;font-size:15px;padding:8px 20px;text-align:center;color:white">
                            Download file
                        </div>

                        @if ($file->state == 2)
                            <div data-bs-toggle="modal" data-bs-target="#formReUpload"
                                style="flex-grow:1; cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Re-upload
                            </div>
                            <div class="modal fade" id="formReUpload" tabindex="-1"
                                aria-labelledby="addCampusFormLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="addCampusFormLabel">Update materials</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST"
                                                action="{{ route('reupload.myims', [
                                                    'id' => $file->id,
                                                ]) }}"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">Instructional
                                                        Material:</label>
                                                    <input class="form-control" type="file" name="file"
                                                        id="formFile">
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100 mt-3"
                                                    style="border:none;background: var(--primaryBG)">Update
                                                    materials</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            @if ($file->status >= 3)
                <h6 style="margin:20px 0 20px 0">Logs:</h6>
                <div class="row">
                    @foreach ($file->logs as $log)
                        @if ($log->trial != 0)
                            @php
                                continue;
                            @endphp
                        @endif
                        <div class="col-12 mb-2">
                            <div class="card">

                                @switch($log->code)
                                    @case(2)
                                        <h6>Plagiarism check By:</h6>
                                    @break

                                    @case(4)
                                        <h6>VPs completed By:</h6>
                                    @break

                                    @default
                                @endswitch

                                <div class="d-flex align-items-center justify-content-between"
                                    style="margin-top: 15px;">
                                    <div class="d-flex align-items-center justify-content-start" style="gap:8px">
                                        <div>
                                            <img src="/{{ $log->proccessBy->profile_image }}"
                                                style="object-fit: cover;border-radius:50%" width="40"
                                                height="40" alt="">
                                        </div>
                                        <div>
                                            <h6>{{ $log->proccessBy->name }}</h6>
                                            <p style="font-size: 14px;font-weight:500">{{ $log->proccessBy->email }}
                                            </p>
                                        </div>
                                    </div>
                                    <a data-bs-toggle="modal" data-bs-target="#a{{ $log->id }}" role="button"
                                        style="font-size: 15px;color:var(--primaryBG);font-weight:500">View
                                        feedback</a>
                                    <div class="modal fade" id="a{{ $log->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Feedback view
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <pre
                                                        style="margin: 10px 0;font-weight:500;white-space: -moz-pre-wrap; /* Mozilla, supported since 1999 */
white-space: -pre-wrap; /* Opera */
white-space: -o-pre-wrap; /* Opera */
white-space: pre-wrap; /* CSS3 - Text module (Candidate Recommendation) http://www.w3.org/TR/css3-text/#white-space */
word-wrap: break-word;">
@php
    echo $log->feedback;
@endphp  
</pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="mt-3">Date: {{ $log->created_at }}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-lg-4" style="border-left: 1px solid rgba(0,0,0,.05);">
            <h6>Comments:</h6>
            <div class="row">
                @forelse ($file->comments as $c)
                    <div class="col-12">
                        <div class="card" style="margin-top:15px">
                            <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                                <img src="/{{ $c->by->profile_image }}" class="rounded-circle"
                                    style="width: 35px;height:35px" alt="Avatar" />
                                <div>
                                    <h6 style="font-size: 14px">{{ $c->by->name }}</h6>
                                    <p style="font-size:12px;font-weight:500" class="email">{{ $c->by->email }}</p>
                                </div>
                            </div>
                            <pre
                                style="margin: 10px 0;font-weight:500;white-space: -moz-pre-wrap; /* Mozilla, supported since 1999 */
white-space: -pre-wrap; /* Opera */
white-space: -o-pre-wrap; /* Opera */
white-space: pre-wrap; /* CSS3 - Text module (Candidate Recommendation) http://www.w3.org/TR/css3-text/#white-space */
word-wrap: break-word;">
@php
    echo $c->comment;
@endphp  
</pre>
                            <p style="font-size: 12px;font-weight:500;">
                                {{ \Carbon\Carbon::parse($c->created_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <h6 style="margin-top: 50px;text-align:center">No comment yet.</h6>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="updateInfo" tabindex="-1" aria-labelledby="addCampusFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCampusFormLabel">Update materials</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST"
                    action="{{ route('update.repo', [
                        'id' => $file->id,
                    ]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Title</label>
                        <input class="form-control" value="{{ $file->title }}" required type="text"
                            name="title" id="">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Type:</label>
                        <select class="form-select" name="type" required aria-label="Default select example">
                            <option selected value="">Select type</option>
                            @foreach ($types as $type)
                                <option @if ($type->id == $file->type) selected @endif
                                    value="{{ $type->id }}">
                                    {{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3"
                        style="border:none;background: var(--primaryBG)">Update materials</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="fileLogs" tabindex="-1" aria-labelledby="formAddCommentsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formAddCommentsLabel">File logs</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @forelse ($file->fileLogs as $item)
                    <div class="card mt-2">
                        <div class="d-flex align-items-center justify-content-between ">
                            <div class="">
                                <h6>{{ $item->filaname }}</h6>
                                <p style="font-size: 14px;font-weight:500">Date Created: {{ $item->created_at }}
                                </p>
                            </div>
                            <a
                                href="{{ route('dllogs.repo', [
                                    'id' => $item->id,
                                ]) }}"><i
                                    class="far fa-download" style='padding:10px'></i></a>
                        </div>
                    </div>
                @empty
                    <center>
                        <h6>Log is empty.</h6>
                    </center>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    document.onkeyup = function(e) {
        if (e.ctrlKey && e.altKey && e.shiftKey && e.which == 85) {

        }
    };
</script>
