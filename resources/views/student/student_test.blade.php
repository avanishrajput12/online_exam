<h3>{{ $test->title }}</h3>
<p><b>Duration:</b> {{ $test->duration }} Minutes</p>
<p><b>Total Questions:</b> {{ $test->testQuestions->count() }}</p>

<button id="startTest" class="btn btn-primary">Start Test</button>

<div id="testArea" style="display:none">

    <h4>Time Left: <span id="timer"></span></h4>

    <form id="submitTestForm">
        @csrf

        @foreach($test->testQuestions as $tq)
        <p><b>{{ $loop->iteration }} . {{ $tq->question->question }}</b></p>

        <input type="radio" name="q{{ $tq->id }}" value="{{ $tq->question->op_1 }}"> {{ $tq->question->op_1 }} <br>
        <input type="radio" name="q{{ $tq->id }}" value="{{ $tq->question->op_2 }}"> {{ $tq->question->op_2 }} <br>
        <input type="radio" name="q{{ $tq->id }}" value="{{ $tq->question->op_3 }}"> {{ $tq->question->op_3 }} <br>
        <input type="radio" name="q{{ $tq->id }}" value="{{ $tq->question->op_4 }}"> {{ $tq->question->op_4 }} <br>
        <hr>
        @endforeach

        <button class="btn btn-success">Submit Test</button>

    </form>

</div>

<script>
$("#startTest").on("click", function(){

    $("#testArea").show();
    $(this).hide();

    let minutes = {{ $test->duration }};
    let seconds = minutes * 60;

    let timer = setInterval(() => {

        let m = Math.floor(seconds / 60);
        let s = seconds % 60;

        document.getElementById("timer").innerHTML = `${m}:${s}`;

        seconds--;

        if(seconds <= 0){
            clearInterval(timer);
            alert("⏳ Time Over! Test Auto Submitted");
            $("#submitTestForm").submit();
        }

    }, 1000);

});
</script>
