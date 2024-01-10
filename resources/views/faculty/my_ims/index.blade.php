@include('faculty.includes.header', ['title' => 'My Instructional Material'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div></div>

                <button class="btn-add-management" id="modal_btn" data-bs-toggle="modal" data-bs-target="#uploadFile"><i
                        class="fa-solid fa-plus"></i> Add new materials</button>

            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>

                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th width="50">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="uploadFile" tabindex="-1" aria-labelledby="addCampusFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCampusFormLabel">Add new materials</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Title</label>
                        <input class="form-control" required type="text" name="title" id="">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Type:</label>
                        <select class="form-select" name="type" required aria-label="Default select example">
                            <option selected value="">Select type</option>

                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">File</label>
                        <input class="form-control" required type="file" name="file" id="formFile">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3"
                        style="border:none;background: var(--primaryBG)">Add materials</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $.ajax({
        type: "POST",
        url: "{{ route('get.myims') }}",

        success: function(response) {
            table = $('#table').DataTable({
                order: [3, 'desc'],
                data: response,
                columns: [{
                        data: 'title'
                    },
                    {
                        data: 't_type.name'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            switch (data) {
                                case 1:
                                    return "For Department Evaluator";
                                case 2:
                                    return "For Plagirism Checker";
                                case 3:
                                    return "For University Evaluator";
                                case 4:
                                    return "For VPs";
                                case 5:
                                    return "Approved";
                                default:
                                    return "";
                            }
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            var birthdate = moment(data).format(
                                'MMMM D, YYYY - hh:mm A');
                            return birthdate;
                        }
                    },
                    {
                        data: 'updated_at',
                        visible: false,
                    },
                    {
                        data: function(data, type, row) {
                            return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/myims/${data.id}/details">View Details</a></li>
                                                
                                            </ul>
                                        </div>`;
                        },

                    },
                ],


            });
        }
    });
</script>
