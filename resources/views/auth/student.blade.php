<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.2.css') }}">
    <style>
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
        .already{
            font-weight: 500;
        }
        .already a{
            color: #0047FF;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="r-container">
        <div class="left">
            <img src="/side-login.png">
        </div>
        <div class="right">
            <h4>Register as Student</h4>
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="org_name" class="form-label">Firstname</label>
                                <input type="text" name="firstname" class="form-control" id="" required>
                                @error('firstname')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="org_name" class="form-label">Lastname</label>
                                <input type="text" name="lastname" class="form-control" id="" required>
                                @error('lastname')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Sex</label>
                                <select class="form-select" name="sex" aria-label="Default select example">
                                    <option selected>Open this select menu</option>

                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                @error('sex')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birthdates</label>
                                <input type="date" name="birthdate" class="form-control" id="birthdate" required>
                                @error('lastname')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                                @error('email')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Profile image:</label>
                                <input type="file" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="image">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                                @error('password')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Comfirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="exampleInputPassword1">
                                @error('password_confirmation')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Select Campus</label>
                                <select class="form-select" name="campus" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    @foreach ($campuses as $campus)
                                        <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                    @endforeach
                                </select>
                                @error('campus')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Select Program</label>
                                <select class="form-select" name="program" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                                @error('program')
                                    <div class="form-text">{{ $message }}</div>
                                @enderror
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
                </div>
            </form>
        </div>
    </div>

    {{-- <h1>Register student</h1>
    <div class="container">
        <div style="max-width: 600px;margin:auto">
            <form method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="org_name" class="form-label">Firstname</label>
                            <input type="text" name="firstname" class="form-control" id="" required>
                            @error('firstname')
                                <div class="form-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="org_name" class="form-label">Lastname</label>
                            <input type="text" name="lastname" class="form-control" id="" required>
                            @error('lastname')
                                <div class="form-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="">Sex:</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input value="male" class="form-check-input" type="radio" name="sex"
                                            id="sex1">
                                        <label class="form-check-label" for="sex1">
                                            Male
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input value="female" class="form-check-input" type="radio" name="sex"
                                            id="sex1">
                                        <label class="form-check-label" for="sex1">
                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Lastname</label>
                            <input type="date" name="birthdate" class="form-control" id="birthdate" required>
                            @error('lastname')
                                <div class="form-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                            @error('email')
                                <div class="form-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            @error('password')
                                <div class="form-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Comfirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="exampleInputPassword1">
                            @error('password_confirmation')
                                <div class="form-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Select Campus</label>
                            <select class="form-select" name="campus" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach ($campuses as $campus)
                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                            @error('campus')
                                <div class="form-text">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Select Program</label>
                            <select class="form-select" name="program" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                @endforeach
                            </select>
                            @error('program')
                                <div class="form-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile image:</label>
                            <input type="file" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" name="image">
                        </div>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Agree with terms and condition</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div> --}}
</body>

</html>
