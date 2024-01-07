@include('admin.includes.header', ['title' => 'Campus Management'])

<div class="container-fluid" style="padding: 20px;margin-top:50px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div></div>
                <button class="btn-add-management" id="modal_btn" data-bs-toggle="modal" data-bs-target="#addCampusForm"><i
                        class="fa-solid fa-plus"></i> Add new
                    campus</button>
            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>          
                        <th>Name</th>
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
<div class="modal fade" id="addCampusForm" tabindex="-1" aria-labelledby="addCampusFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCampusFormLabel">Add New Campus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('store.campus') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Campus Name:</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Address:</label>
                        <input type="text" name="address" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <button type="submit" class="btn btn-primary w-100"
                        style="border:none;background: var(--primaryBG)">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajax({
        type: "POST",
        url: "{{ route('retrieve.campus') }}",

        success: function(response) {
            
            table = $('#table').DataTable({
                order: [4, 'desc'],
                data: response,
                columns: [
                    {
                        data: 'name'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            switch (data) {
                                case 1:
                                    return "Active";
                                case 2:
                                    return "Inactive";
                                default:
                                    break;
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
                                                <li><a class="dropdown-item">View Order</a></li>
                                                
                                            </ul>
                                        </div>`;
                        },

                    },
                ],


            });
        }
    });
</script>
