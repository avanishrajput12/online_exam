<h5>Title: {{ $test->title }}</h5>
<p><b>Total Questions:</b> {{ $test->testQuestions->count() }}</p>

<hr>

@foreach($test->testQuestions as $tq)
    <p><b>Q{{ $loop->iteration }}:</b> {{ $tq->question->question }}</p>

    <ul>
        <li>A: {{ $tq->question->op_1 }}</li>
        <li>B: {{ $tq->question->op_2 }}</li>
        <li>C: {{ $tq->question->op_3 }}</li>
        <li>D: {{ $tq->question->op_4 }}</li>
    </ul>

    <p><b>Correct:</b> {{ $tq->question->correct }}</p>
    <hr>
@endforeach
