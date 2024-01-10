@include('admin.includes.header', ['title' => 'Dashboard'])
@php
    use App\Classes\AdminDashboard;
@endphp
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <h6 style="margin-bottom: 10px">Total Campus</h6>
                <h1>{{ AdminDashboard::totalCampus() }}</h1>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <h6 style="margin-bottom: 10px">Total College</h6>
                <h1>{{ AdminDashboard::totalCollege() }}</h1>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <h6 style="margin-bottom: 10px">Total Department</h6>
                <h1>{{ AdminDashboard::totalDepartment() }}</h1>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <h6 style="margin-bottom: 10px">Total Instructional Materials</h6>
                <h1>{{ AdminDashboard::totalIms() }}</h1>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <h6>User summary</h6>
                <div>
                    <canvas id="userSummary" width="300" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <h6>Overall Instructional Materials</h6>
                <div>
                    <canvas id="myChart" width="300" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    overallImsChart();
    userSummary();

    function userSummary() {
        const ctx = document.getElementById('userSummary');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Faculty', 'Chair', 'Plagiarism Checker', 'University Evaluator',
                    'Vps'
                ],
                datasets: [{
                    label: '',
                    data: ['{{ AdminDashboard::getUserBasedOnStatus(1) }}',
                        '{{ AdminDashboard::getUserBasedOnStatus(2) }}',
                        '{{ AdminDashboard::getUserBasedOnStatus(3) }}',
                        '{{ AdminDashboard::getUserBasedOnStatus(4.1) }}',
                        '{{ AdminDashboard::getUserBasedOnStatus(5) }}'
                    ],
                    borderWidth: 1,
                    backgroundColor: '#072B86',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function overallImsChart() {
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Under Department Evaluator', 'Under plagirism Cheking', 'Under Univesity Evaluator',
                    'Under VPs', 'Approved'
                ],
                datasets: [{
                    label: '',
                    data: ['{{ AdminDashboard::getImsBasedOnStatus(1) }}',
                        '{{ AdminDashboard::getImsBasedOnStatus(2) }}',
                        '{{ AdminDashboard::getImsBasedOnStatus(3) }}',
                        '{{ AdminDashboard::getImsBasedOnStatus(4) }}',
                        '{{ AdminDashboard::getImsBasedOnStatus(5) }}'
                    ],
                    borderWidth: 1,
                    backgroundColor: '#072B86',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
