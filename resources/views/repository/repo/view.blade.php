@if (Auth::user()->type == 2)
    @include('admin.includes.header', ['title' => 'Instructional Material details'])
@else
    @include('repository.includes.header', ['title' => 'Instructional Material details'])
@endif
<div class="container-fluid" style="padding: 20px;margin-top:70px">
    <div class="row">
        <div class="col-lg-8">
            <h6 style="margin-bottom: 5px;font-size:18px">Title: {{ $file->title }}</h6>
            <h6 style="margin-bottom: 10px;font-size:18px">Type: {{ $file->t_type->name }}</h6>
            <div class="d-flex align-items-center justify-content-between">
                <h6 style="line-height: 25px;margin-bottom:15px;font-size:17px">Status: @switch($file->status)
                        @case(1)
                            Waiting for Department evaluation
                        @break

                        @case(2)
                            Waiting for Plagiarism Check
                        @break

                        @case(3)
                            Waiting for University evaluation
                        @break

                        @case(4)
                            Waiting for VPs
                        @break

                        @case(5)
                            Approved
                        @break

                        @default
                    @endswitch
                </h6>
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

                <div class="dropdown">
                    <i class="far fa-ellipsis-v" style="font-size: 21px" data-bs-toggle="dropdown"
                        aria-expanded="false"></i>

                    <ul class="dropdown-menu">
                        @if (Auth::user()->id == $file->user_id)
                            <li><a class="dropdown-item" role="button" data-bs-toggle="modal"
                                    data-bs-target="#updateFile">Update</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div style="margin:20px 0;width: 100%;height:1px;background:rgba(0, 0, 0, .05)">
            </div>
            <h6 style="line-height: 25px">File name: {{ $file->original_name }}</h6>
            <h6 style="line-height: 25px">Date Uploaded: {{ $file->created_at }}</h6>
            <h6 style="line-height: 25px">Date last Updated: {{ $file->updated_at }}</h6>

            @if (Auth::user()->designation == 1 || Auth::user()->designation == 0)
                <div class="row" style="margin-top: 15px;">
                    <div class="col-6">
                        <div onClick="location.href='/file/repository/{{ $file->id }}/download';"
                            style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                            Download file
                        </div>
                    </div>
                    @if ($file->status != 1)
                        <div class="col-6">
                            <div onClick="location.href='/file/repository/{{ $file->id }}/viewScoreOnly';"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                View Score
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Modal -->
                <div class="modal fade" id="updateFile" tabindex="-1" aria-labelledby="addCampusFormLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addCampusFormLabel">Update materials</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
                                        <select class="form-select" name="type" required
                                            aria-label="Default select example">
                                            <option selected value="">Select type</option>

                                            @foreach ($types as $type)
                                                <option @if ($type->id == $file->type) selected @endif
                                                    value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">File</label>
                                        <input class="form-control" type="file" name="file" id="formFile">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mt-3"
                                        style="border:none;background: var(--primaryBG)">Update materials</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            @if (Auth::user()->designation == 4.1)
                <div class="row" style="margin-top: 15px;">
                    @if ($file->status == 3)
                        <div class="col-6 mt-3">
                            <div onClick="location.href='/file/repository/{{ $file->id }}/viewAddScore/university';"
                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Add score
                            </div>
                        </div>
                    @endif

                    <div class="col-6 mt-3">
                        <div onClick="location.href='/file/repository/{{ $file->id }}/download';"
                            style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                            Download file
                        </div>
                    </div>
                    @if ($file->status != 1)
                        <div class="col-6  mt-3">
                            <div onClick="location.href='/file/repository/{{ $file->id }}/viewScoreOnly';"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                View Score
                            </div>
                        </div>
                    @endif
                    @if ($file->status == 3)
                        <div class="col-6  mt-3">
                            <div data-bs-toggle="modal" data-bs-target="#formAddComments"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Add comments
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            @if (Auth::user()->designation == 4.2)
                <div class="row" style="margin-top: 15px;">
                    @if ($file->matrices_id == 0)
                        <div class="col-6 mt-3">
                            <div data-bs-toggle="modal" data-bs-target="#exampleModal"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Set matrix
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Select matrix</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="{{ route('set_matrix.repo', [
                                                'id' => $file->id,
                                            ]) }}"
                                            method="post">
                                            @csrf
                                            @foreach ($matrix as $m)
                                                <div class="form-check">
                                                    <input class="form-check-input" value="{{ $m->id }}"
                                                        type="radio" name="matrices_id" id="">
                                                    <label class="form-check-label" for="">
                                                        {{ $m->title }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            <button type="submit" class="btn btn-primary w-100 mt-3"
                                                style="border:none;background: var(--primaryBG)">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @if ($file->status == 1)
                            <div class="col-6 mt-3">
                                <div onClick="location.href='/file/repository/{{ $file->id }}/viewAddScore';"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                    Add score
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="col-6 mt-3">
                        <div onClick="location.href='/file/repository/{{ $file->id }}/download';"
                            style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                            Download file
                        </div>
                    </div>
                    @if ($file->status != 1)
                        <div class="col-6  mt-3">
                            <div onClick="location.href='/file/repository/{{ $file->id }}/viewScoreOnly';"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                View Score
                            </div>
                        </div>
                    @endif
                    @if ($file->status == 1)
                        <div class="col-6  mt-3">
                            <div data-bs-toggle="modal" data-bs-target="#formAddComments"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Add comments
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            @if (Auth::user()->designation == 3)
                <div class="row" style="margin-top: 15px;">
                    @if ($file->status != 1)
                        <div class="col-6  mt-3">
                            <div onClick="location.href='/file/repository/{{ $file->id }}/viewScoreOnly';"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                View Score
                            </div>
                        </div>
                    @endif
                    <div class="col-6 mt-3">
                        <div onClick="location.href='/file/repository/{{ $file->id }}/download';"
                            style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                            Download file
                        </div>
                    </div>

                    @if ($file->status == 2)
                        <div class="col-6 mt-3">
                            <div data-bs-toggle="modal" data-bs-target="#formAddComments"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Add comments
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <div data-bs-toggle="modal" data-bs-target="#plag"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Set Plagiarism completed
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="plag" tabindex="-1" aria-labelledby="formAddCommentsLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="formAddCommentsLabel">Plagiarism Feedback
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="{{ route('plagiarism.repo', [
                                                'id' => $file->id,
                                            ]) }}"
                                            method="post">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="feedback" placeholder="Leave a comment here" id="floatingTextarea2"
                                                    style="height: 100px"></textarea>
                                                <label for="floatingTextarea2">Feedback</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100"
                                                style="border:none;background: var(--primaryBG)"> Set Plagiarism
                                                completed
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if (Auth::user()->designation == 5)
                <div class="row" style="margin-top: 15px;">
                    @if ($file->status != 1)
                        <div class="col-6  mt-3">
                            <div onClick="location.href='/file/repository/{{ $file->id }}/viewScoreOnly';"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                View Score
                            </div>
                        </div>
                    @endif
                    <div class="col-6 mt-3">
                        <div onClick="location.href='/file/repository/{{ $file->id }}/download';"
                            style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                            Download file
                        </div>
                    </div>
                    @if ($file->status == 4)
                        <div class="col-6 mt-3">
                            <div data-bs-toggle="modal" data-bs-target="#vps"
                                style="cursor:pointer;border-radius:5px;background: var(--primaryBG);font-size:15px;padding:8px 20px;text-align:center;color:white">
                                Set VPs completed
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="vps" tabindex="-1" aria-labelledby="formAddCommentsLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="formAddCommentsLabel">VPs Feedback
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="{{ route('vps.repo', [
                                                'id' => $file->id,
                                            ]) }}"
                                            method="post">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="feedback" placeholder="Leave a comment here" id="floatingTextarea2"
                                                    style="height: 100px"></textarea>
                                                <label for="floatingTextarea2">Feedback</label>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100"
                                                style="border:none;background: var(--primaryBG)"> Set
                                                Vps Completed
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            @if ($file->status != 1)
                <h6 style="margin:20px 0 20px 0">Logs:</h6>
                <div class="row">
                    @foreach ($file->logs as $log)
                        <div class="col-12 mb-2">
                            <div class="card">

                                @switch($log->code)
                                    @case(1)
                                        <h6>Department Evaluated By:</h6>
                                    @break

                                    @case(2)
                                        <h6>Plagiarism check By:</h6>
                                    @break

                                    @case(3)
                                        <h6>University Evaluated By:</h6>
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
<div class="modal fade" id="formAddComments" tabindex="-1" aria-labelledby="formAddCommentsLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formAddCommentsLabel">Add comment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('comment.repo', [
                    'id' => $file->id,
                ]) }}"
                    method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="comment" placeholder="Leave a comment here" id="floatingTextarea2"
                            style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Comments</label>
                    </div>
                    <p style="font-size: 15px;font-weight:500;margin-bottom:15px">Note: It will automatically email the
                        faculty.</p>
                    <button type="submit" class="btn btn-primary w-100"
                        style="border:none;background: var(--primaryBG)">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
