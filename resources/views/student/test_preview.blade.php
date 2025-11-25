<!doctype html>
<html>
<head>
    <title>Test Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">

    <div class="card p-4">
        <h2>{{ $test->title }} - Result</h2>

        <h4 class="mt-3">Score: {{ $result->score }} / {{ $result->total_questions }}</h4>
        <h5 class="text-success">Percentage: {{ number_format($result->percentage, 2) }}%</h5>

        <a href="/student/test/review/{{ $result->id }}" class="btn btn-primary mt-3">
            Review Answers
        </a>
    </div>

</div>

</body>
</html>
