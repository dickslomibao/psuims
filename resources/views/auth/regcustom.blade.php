<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.2.css') }}">
    <script src="{{ asset('js/jq.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <style>
        .check-label {
            color: green;
            margin-left: 5px;
            display: none;
        }

        label.error {
            color: rgba(255, 0, 0, 0.7);
            font-weight: 500;
            font-size: 13px;
            margin-top: 5px;
        }

        body * {
            font-family: 'roboto', sans-serif;
        }

        .left {
            flex: 1;

        }

        .left img {
            width: 100%;
            height: 100vh;
        }

        .right {
            flex: 1;
            padding: 20px 40px;
        }

        .r-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .button-register {
            margin: 15px 0;
            width: 100%;
            background-color: #0047FF;
            border: none;
            outline: none;
            border-radius: 5px;
            padding: 8px 20px;
            font-family: 500;
            color: white;
        }

        label {
            font-size: 15px;
            font-weight: 500;
        }

        .mb-3 {
            margin-bottom: 10px !important;
        }

        h4 {
            margin-bottom: 20px;
        }

        input:hover {
            border: 1px solid #0047FF;
        }

        .form-control:focus {
            border-color: rgb(0, 72, 255);
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(0, 72, 255, 0.5);
        }

        .already {
            font-weight: 500;
        }

        .already a {
            color: #0047FF;
            text-decoration: none;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
</head>

<body>
    <div class="r-container">
        <div class="left">
            <img src="/side-login.png">
        </div>
        <div class="right">
            <h4>Create an account</h4>
            <form method="POST" id="register" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="org_name" class="form-label">Your name <i id="check-name"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="text" name="name" id="name" class="form-control">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Select Campus <i id="check-campus"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <select class="form-select" id="campus" name="campus"
                                aria-label="Default select example">
                                <option selected value="">Open this select menu</option>
                                @foreach ($campuses as $campus)
                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Select College
                                <i id="check-college" class="fa-solid fa-check check-label" style=""></i></label>
                            <select id="college" class="form-select" name="college"
                                aria-label="Default select example">
                                <option selected value="">Open this select menu</option>
                                @foreach ($college as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Select Department <i
                                    id="check-department" class="fa-solid fa-check check-label"
                                    style=""></i></label>
                            <select id="department" class="form-select" name="department"
                                aria-label="Default select example">
                                <option selected value="">Open this select menu</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address <i id="check-email"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="email" id="email" name="email" class="form-control"
                                id="exampleInputEmail1" aria-describedby="emailHelp">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile image: <i id="check-image"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password <i id="check-password"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="password" name="password" id="password" class="form-control"
                                id="exampleInputPassword1">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Comfirm Password <i
                                    id="check-password_confirmation" class="fa-solid fa-check check-label"
                                    style=""></i></label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="password_confirmation">

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Select Destination <i
                                    id="check-designation" class="fa-solid fa-check check-label"
                                    style=""></i></label>
                            <select class="form-select" id="designation" name="designation"
                                aria-label="Default select example">
                                <option selected value="">Open this select menu</option>
                                <option value="1">Facullty</option>
                                <option value="2">Chair</option>
                                <option value="3">C.F.L</option>
                                <option value="4.1">University Evaluator</option>
                                <option value="4.2">Department Evaluator</option>
                                <option value="5">V.P</option>
                                <option value="6">GP</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="mb-3 form-check" style="margin-top: 15px">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Agree with terms and condition</label>
                </div>
                <button type="submit" class="button-register">Create account</button>
                <center>
                    <span class="already">Already have an account? <a href="/login">Login</a></span>
                </center>
            </form>
        </div>
    </div>
    <script>
        $('#college').change(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('college.department') }}",
                data: {
                    id: $(this).val(),
                },
                success: function(response) {

                    $('#department').empty();
                    response.forEach(element => {
                        $('#department').append(
                            `<option value="${element.id}">${element.name}</option>`)
                    });

                }
            });
        });

        $("#register").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },
            rules: {
                name: {
                    required: true,
                },
                campus: {
                    required: true,
                },
                college: {
                    required: true,
                },
                department: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                image: {
                    required: true,
                },
                designation: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: 'Name is required',
                },
                campus: {
                    required: 'Campus is required',
                },
                college: {
                    required: 'College is required',
                },
                department: {
                    required: 'Department is required',
                },
                email: {
                    required: "Email address is required",
                    email: "Please enter a valid email address",

                },
                password: {
                    required: "Password is required",
                },
                "password_confirmation": {
                    required: "Comfirm password is required",
                    equalTo: "Passwords did not match"
                },
                image: {
                    required: 'Profile picture is required.'
                },
                designation: {
                    required: "Designation is required",
                },
            },
            submitHandler: function(form) {
                const formData = new FormData(form);
                $.ajax({
                    type: "POST",
                    url: "/register",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response.code == 200) {
                            location.href = "/";
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
