<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="{{ asset('css/static.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.2.css') }}">

    <link rel="stylesheet" href="{{ asset('css/data_table_bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <script src="{{ asset('js/jq.js') }}"></script>

    <script src="{{ asset('js/bootstrap5.2.js') }}"></script>
    <script src="{{ asset('js/data_table.js') }}"></script>
    <script src="{{ asset('js/data_table_bootstrap.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body>
    <div class="side-nav">
        <div>

            <div class="d-flex align-items-center justify-content-center top">
                <div class="logo">
                    <img src="/logo/LOGO 3.png" alt="" height="70">
                </div>
            </div>

            <div class="container-links">
                <span style="font-size: 12px;font-weight:600;">Analyze</span>

                <ul style="margin:10px 0">
                    <li class="active">
                        <a href="#"><i class="fa-solid fa-chart-pie"></i><span>Dashboard</span></a>
                    </li>
                    {{-- <li class="">
                        <a href="#"><i class="fal fa-signal-alt-3"></i><span>Reports</span></a>
                    </li> --}}

                </ul>
                <span style="font-size: 12px;font-weight:600;">Management</span>
                <ul style="margin-top: 10px">
                    @if (Auth::user()->designation == 1 || Auth::user()->designation == 2)
                        <li class="{{ request()->routeIs('index.myims') ? 'selected-route' : '' }}">
                            <a href="{{ route('index.myims') }}">
                                @if (request()->routeIs('index.myims'))
                                    <i class="fas fa-book-open"></i>
                                @else
                                    <i class="fal fa-book"></i>
                                @endif
                                <Span>My Materials</Span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->user_is_in_dept_evaluator || Auth::user()->designation != 1)
                        <li class="{{ request()->routeIs('index.repo') ? 'selected-route' : '' }} d-flex align-items-center"
                            style="gap: 10px">
                            <a href="{{ route('index.repo') }}">
                                @if (request()->routeIs('index.repo'))
                                    <i class="fas fa-book-open"></i>
                                @else
                                    <i class="fal fa-book-user"></i>
                                @endif
                                <span>Evaluate Materials
                                </span>

                            </a>
                            {{-- @if (Auth::user()->designation == 3)
                                <div style="height:18px;width:18px ;background:var(--secondaryBG);color:var(--primaryBG);font-size:10px;font-weight:500;border-radius: 50%"
                                    class="d-flex align-items-center justify-content-center">
                                    @if (\App\Classes\InstructionalMaterialClass::totalPendingOnPlagiarism() > 9)
                                        {{ \App\Classes\InstructionalMaterialClass::totalPendingOnPlagiarism() }}+
                                    @else
                                        {{ \App\Classes\InstructionalMaterialClass::totalPendingOnPlagiarism() }}
                                    @endif
                                </div>
                            @elseif (Auth::user()->designation == 4.1)
                                <div style="height:18px;width:18px ;background:var(--secondaryBG);color:var(--primaryBG);font-size:10px;font-weight:500;border-radius: 50%"
                                    class="d-flex align-items-center justify-content-center">
                                    @if (\App\Classes\InstructionalMaterialClass::totalPendingOnUe() > 9)
                                        {{ \App\Classes\InstructionalMaterialClass::totalPendingOnUe() }}+
                                    @else
                                        {{ \App\Classes\InstructionalMaterialClass::totalPendingOnUe() }}
                                    @endif
                                </div>
                            @else
                                <div style="height:18px;width:18px ;background:var(--secondaryBG);color:var(--primaryBG);font-size:10px;font-weight:500;border-radius: 50%"
                                    class="d-flex align-items-center justify-content-center">
                                    @if (\App\Classes\InstructionalMaterialClass::totalPendingOnDeptEvaluation() > 9)
                                        {{ \App\Classes\InstructionalMaterialClass::totalPendingOnDeptEvaluation() }}+
                                    @else
                                        {{ \App\Classes\InstructionalMaterialClass::totalPendingOnDeptEvaluation() }}
                                    @endif
                                </div>
                            @endif --}}

                        </li>
                    @endif
                    @if (Auth::user()->designation == 2)
                        <li class="{{ request()->routeIs('index.departmentevaluator') ? 'selected-route' : '' }}">
                            <a href="{{ route('index.departmentevaluator') }}">
                                @if (request()->routeIs('index.departmentevaluator'))
                                    <i class="fas fa-user-check"></i>
                                @else
                                    <i class="fal fa-user-check"></i>
                                @endif
                                <Span>Department Evaluator</Span>
                            </a>
                        </li>
                    @endif
                </ul>


            </div>
        </div>

    </div>
    <div class="right-content">

        <div class="header">
            <h5 class="title">{{ $title }}</h5>
            <div class="d-flex align-items-center justify-content-center">

                <h6>Hi, {{ Auth::user()->name }}</h6>
                <div class="dropdown" style="margin-left: 10px">
                    <i class="far fa-caret-down" data-bs-toggle="dropdown" aria-expanded="false"></i>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/logout" style="font-size: 15px;color:#000">Logout</a></li>
                    </ul>
                </div>
            </div>
            {{-- <i class="fa-regular fa-right-from-bracket"></i> --}}
            {{-- <div class="d-flex align-items-center" style="gap: 30px">
                <div class="custom-badge">
                    <i class="fal fa-bell"></i>
                    <span class="">8</span>
                </div>
                <div class="custom-badge">
                    <i class="fal fa-envelope"></i>
                    {{Auth::user()->type}}
        </div>

    </div> --}}
        </div>
