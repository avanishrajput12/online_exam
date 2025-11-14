<!DOCTYPE html>
<html>
<head>
    <title>Test Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .timer {
            font-size: 22px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body class="p-4">

    <h3>Test: {{ $test->title }}</h3>
    <p>Total Questions: {{ $test->testQuestions->count() }}</p>

    <h4 class="timer">Time Left: <span id="time">05:00</span></h4>

   <form id="submitForm" method="POST" action="{{ url('/student/test/submit/'.$test->id) }}">
    @csrf

    @foreach($test->testQuestions as $i => $tq)
    <div class="card p-3 mb-2">
        <p><b>Q{{ $i+1 }}:</b> {{ $tq->question->question }}</p>

        <label><input type="radio" name="ans[{{ $tq->question->id }}]" value="{{ $tq->question->op_1 }}"> {{ $tq->question->op_1 }}</label><br>
        <label><input type="radio" name="ans[{{ $tq->question->id }}]" value="{{ $tq->question->op_2 }}"> {{ $tq->question->op_2 }}</label><br>
        <label><input type="radio" name="ans[{{ $tq->question->id }}]" value="{{ $tq->question->op_3 }}"> {{ $tq->question->op_3 }}</label><br>
        <label><input type="radio" name="ans[{{ $tq->question->id }}]" value="{{ $tq->question->op_4 }}"> {{ $tq->question->op_4 }}</label>
    </div>
    @endforeach

    <button class="btn btn-primary mt-3" id="submitBtn">Submit Test</button>
</form>

<script>
let totalSeconds = 300;

let timer = setInterval(function(){

    let min = Math.floor(totalSeconds / 60);
    let sec = totalSeconds % 60;

    document.getElementById("time").innerHTML =
        (min < 10 ? "0" + min : min) + ":" +
        (sec < 10 ? "0" + sec : sec);

    if(totalSeconds <= 0){
        clearInterval(timer);
        alert("Time Over! Auto Submitting...");
        document.getElementById("submitBtn").click();
    }

    totalSeconds--;

}, 1000);
</script>

</body>
</html>
