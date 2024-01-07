@include('admin.includes.header', ['title' => $matrix->title])

<div class="container-fluid" style="padding: 20px;margin-top:50px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div></div>
                @if ($percentage < 100) <button class="btn-add-management" id="modal_btn" data-bs-toggle="modal" data-bs-target="#addCampusForm"><i class="fa-solid fa-plus"></i> Add matrix criteria</button>

                    @endif
            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Title </th>
                        <th>Percentage</th>
                        <th>Sub Criteria current percentage</th>
                        <th>Date Created</th>
                        <th>Date Updated </th>
                        <th width="50">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addCampusForm" tabindex="-1" aria-labelledby="addCampusFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCampusFormLabel">Add new criteria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="add-criteria-form">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Criteria title:</label>
                        <input type="text" name="title" required class="form-control" id="title" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Criteria percentage (100 = 100%):</label>
                        <input type="number" name="percentage" required class="form-control" id="percentage" aria-describedby="emailHelp">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="border:none;background: var(--primaryBG)">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $("#add-criteria-form").validate({
        rules: {
            title: {
                required: true,
            },
            percentage: {
                required: true,
                max: parseFloat('{{100 - $percentage}}'),
            },
        },
        messages: {
            title: {
                required: "Please enter your title",
            },
            percentage: {
                required: "Please enter your percentage",

            },
        },
        submitHandler: function(form) {
            const formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: `{{ route('add.matrix_criteria',[
                'id'=>$matrix->id
            ]) }}`,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response.code == 200) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
    $.ajax({
        type: "POST",
        url: "/admin/matrix/{{$matrix->id}}/view/criteria",

        success: function(response) {
            console.log(response);
            table = $('#table').DataTable({
                order: [2, 'desc'],
                data: response,
                columns: [{
                        data: 'title'
                    },

                    {
                        data: 'percentage',
                        render: function(data, type, row) {
                            return data + "%";
                        }
                    },
                    {
                        data: 'total_sub_criteria_percentage',
                        render: function(data, type, row) {
                            return data + "%";
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
        <li><a href="/admin/matrix/{{$matrix->id}}/view/matix_criteria/${data.id}/view" class="dropdown-item" >View Criteria </a></li>
    </ul>
</div>`;
                        },

                    },
                ],


            });
        }
    });
</script>