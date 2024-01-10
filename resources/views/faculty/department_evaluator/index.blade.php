@include('faculty.includes.header', ['title' => 'Department Evaluator'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div></div>

                <button class="btn-add-management" id="modal_btn" data-bs-toggle="modal"
                    data-bs-target="#modalDepartmentEvaluator"><i class="fa-solid fa-plus"></i> Add new Evaluator</button>

            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Faculty</th>
                        {{-- <th>Status</th> --}}
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
<div class="modal fade" id="modalDepartmentEvaluator" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add new department Evaluator</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            @foreach ($faculty as $f)
                                <div class="mb-3 d-flex align-items-center justify-content-between" style="gap:10px">

                                    <div class="d-flex align-items-center justify-content-start" style="gap:10px">
                                        <img src="/{{ $f->profile_image }}" alt="" srcset=""
                                            style="width: 45px;height:45px;border-radius:50%;object-fit: cover">
                                        <div>
                                            <h6>{{ $f->name }}</h6>
                                            <p style="font-weight: 500;font-size:15px">{{ $f->email }}</p>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{ $f->id }}"
                                            name="faculty" id="">
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


<script>
    $.ajax({
        type: "POST",
        url: "{{ route('get.departmentevaluator') }}",

        success: function(response) {
            if (response.length >= 2) {
                $('#modal_btn').hide();
            }
            table = $('#table').DataTable({
                order: [3, 'desc'],
                data: response,
                columns: [{
                        data: function(data, type, row) {
                            return `
                                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                                <img src="/${data.faculty.profile_image}" class="rounded-circle"
                                style="width: 40px;height:40px" alt="Avatar" />
                                <div>
                                <h6>${data.faculty.name}</h6>
                                <p style="font-size:14px" class="email">${data.faculty.email}</p>
                                </div>
                                </div>                             
                                `;
                        }

                    },

                    // {
                    //     data: 'status',
                    //     render: function(data, type, row) {
                    //         switch (data) {
                    //             case 1:
                    //                 return "Active";
                    //             case 2:
                    //                 return "Inactive";

                    //                 return "";
                    //         }
                    //     }
                    // },
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
                                                <li><a class="dropdown-item" href="/departmentevaluator/${data.id}/remove">Remove</a></li>
                                                
                                            </ul>
                                        </div>`;
                        },

                    },
                ],


            });
        }
    });
</script>
