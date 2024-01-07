@include('repository.includes.header', ['title' => 'View Score'])
<div class="container-fluid" style="padding: 20px;margin-top:70px">
    <div class="row">
        <div class="col-12">

            @foreach ($matrix as $m)
                <h6 style="margin-bottom: 20px;font-size:17px;font-weight:600">{{ $m->title }}
                    ({{ $m->percentage }}%)</h6>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 50%;">
                                    Title
                                </th>
                                <th>
                                    Percantage
                                </th>
                                <th>
                                    Deparment Score
                                </th>
                                <th>
                                    University Score
                                </th>
                            </tr>
                            @foreach ($m->subCriteria as $sub)
                                <tr>
                                    <td style="width: 50%;">
                                        {{ $sub->title }}
                                    </td>
                                    <td>
                                        {{ $sub->percentage }} %
                                    </td>
                                    <td>
                                        {{ $sub->score }}%
                                    </td>
                                    <td>
                                        {{ $sub->u_score }}%
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endforeach

            @foreach ($file->logs as $log)
                @if ($log->code == 1)
                    <h6 style="margin-bottom: 20px;font-size:17px;font-weight:600">Deparment Evaluated By:</h6>
                    <div class="d-flex align-items-center justify-content-between" style="margin:  25px 0;">
                        <div class="d-flex align-items-center justify-content-start" style="gap:8px">
                            <div>
                                <img src="/{{ $log->proccessBy->profile_image }}"
                                    style="object-fit: cover;border-radius:50%" width="40" height="40"
                                    alt="">
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
                @endif

                @if ($log->code == 3)
                    <h6 style="margin-bottom: 20px;font-size:17px;font-weight:600">University Evaluated By:</h6>

                    <div class="d-flex align-items-center justify-content-between" style="margin: 15px 0 25px 0;">
                        <div class="d-flex align-items-center justify-content-start" style="gap:8px">
                            <div>
                                <img src="/{{ $log->proccessBy->profile_image }}"
                                    style="object-fit: cover;border-radius:50%" width="40" height="40"
                                    alt="">
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
                @endif
            @endforeach
        </div>
    </div>
</div>
