<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Test</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f5f7;
        }
        .question-card {
            border-left: 5px solid #0d6efd;
            background: #fff;
        }
        .timer-box {
            font-size: 24px;
            font-weight: bold;
            color: red;
            text-align: right;
        }
        .option-label {
            cursor: pointer;
            padding: 7px 12px;
            border-radius: 8px;
        }
        .option-input:checked + .option-label {
            background: #cfe2ff;
            border: 1px solid #0d6efd;
            font-weight: bold;
        }
    </style>
</head>
<body class="p-4">

<div class="container">

    <h2 class="mb-2">{{ $test->title }}</h2>
    <p class="text-muted">Total Questions: {{ $test->testQuestions->count() }}</p>

    <div class="timer-box mb-3">
        Time Left: <span id="time">{{ $test->duration }}:00</span>
    </div>

    <form method="POST" action="{{ route('student.test.submit', $test->id) }}" id="testForm">
        @csrf

        @foreach($test->testQuestions as $index => $tq)
            <div class="card p-3 mb-3 question-card">

                <h5>Q{{ $index+1 }}. {{ $tq->question->question }}</h5>

                <div class="mt-2">
                    <input type="radio" class="option-input d-none"
                           name="ans[{{ $tq->question->id }}]" id="q{{ $tq->id }}_1" value="op_1">
                    <label for="q{{ $tq->id }}_1" class="option-label d-block">
                        A) {{ $tq->question->op_1 }}
                    </label>

                    <input type="radio" class="option-input d-none"
                           name="ans[{{ $tq->question->id }}]" id="q{{ $tq->id }}_2" value="op_2">
                    <label for="q{{ $tq->id }}_2" class="option-label d-block">
                        B) {{ $tq->question->op_2 }}
                    </label>

                    <input type="radio" class="option-input d-none"
                           name="ans[{{ $tq->question->id }}]" id="q{{ $tq->id }}_3" value="op_3">
                    <label for="q{{ $tq->id }}_3" class="option-label d-block">
                        C) {{ $tq->question->op_3 }}
                    </label>

                    <input type="radio" class="option-input d-none"
                           name="ans[{{ $tq->question->id }}]" id="q{{ $tq->id }}_4" value="op_4">
                    <label for="q{{ $tq->id }}_4" class="option-label d-block">
                        D) {{ $tq->question->op_4 }}
                    </label>
                </div>

            </div>
        @endforeach

        <button class="btn btn-success w-100 mt-4" id="submitBtn">Submit Test</button>
    </form>
</div>
<script>


let totalSeconds = {{ $test->duration }} * 60;

let interval = setInterval(() => {
    let min = Math.floor(totalSeconds / 60);
    let sec = totalSeconds % 60;
    document.getElementById("time").innerHTML =
        (min < 10 ? "0"+min : min) + ":" + (sec < 10 ? "0"+sec : sec);
    if (totalSeconds <= 0) {
        clearInterval(interval);
        alert("Time Over! Submitting test...");
        document.getElementById("testForm").submit();
    }
    totalSeconds--;
}, 1000);
</script>

</body>
</html>
