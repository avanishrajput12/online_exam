<h5>Title: {{ $test->title }}</h5>
<p><b>Total Questions:</b> {{ $test->questions->count() }}</p>

<hr>

@foreach($test->questions as $q)
<p><b>Q{{ $loop->iteration }}:</b> {{ $q->question->question }}</p>
<ul>
    <li>A: {{ $q->question->op_1 }}</li>
    <li>B: {{ $q->question->op_2 }}</li>
    <li>C: {{ $q->question->op_3 }}</li>
    <li>D: {{ $q->question->op_4 }}</li>
</ul>
<p><b>Correct:</b> {{ $q->question->correct }}</p>
<hr>
@endforeach
