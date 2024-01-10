@include('faculty.includes.header', ['title' => 'Add Score'])

<div class="container-fluid" style="padding: 20px;margin-top:70px">
    <div class="row">
        <div class="col-12">
            <form action="" method="post">
                @csrf
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
                                    <th style="width: 50%;">
                                        Score
                                    </th>
                                </tr>
                                @foreach ($m->subCriteria as $sub)
                                    <tr>
                                        <td style="width: 50%;">
                                            {{ $sub->title }}
                                        </td>
                                        <td>
                                            {{ $sub->percentage }}%
                                        </td>
                                        <td style="width: 50%;">
                                            <input type="number" value="{{ $sub->score }}" required
                                                max="{{ $sub->percentage }}" min="0" class="form-control"
                                                name="{{ $m->id }}-{{ $sub->id }}"
                                                id="{{ $m->id }}{{ $sub->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endforeach
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Feedback</label>
                    <textarea required class="form-control" name="feedback" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-3">
                    <button class="btn btn-primary"
                        style="padding:8px 30px;background-color: var(--primaryBG);border:none">Add
                        score</button>
                </div>
            </form>
        </div>
    </div>
</div>
