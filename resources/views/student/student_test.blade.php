<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Start Test - {{ $test->title }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --primary: #0d6efd;
      --accent: #ffc107;
      --marked: #6f42c1;
    }

    body { background:#f2f5f7; }
    .question-card { border-left:5px solid var(--primary); background:#fff; border-radius:.4rem; }
    .option-label { cursor:pointer; padding:12px 14px; border-radius:8px; display:block; transition:all .12s ease; border:1px solid transparent; }
    .option-input:checked + .option-label { background:#cfe2ff; border-color:var(--primary); font-weight:600; }
    .timer-box { font-weight:700; font-size:1.05rem; color:#fff; background:var(--primary); padding:.35rem .6rem; border-radius:.35rem; }
    .palette-item { min-width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:6px; cursor:pointer; border:1px solid #ddd; background:#fff; }
    .palette-wrap { gap:.5rem; display:flex; flex-wrap:wrap; }
    .palette-item.answered { background:#198754; color:#fff; border-color:transparent; }
    .palette-item.marked { background:var(--marked); color:#fff; }
    .palette-item.current { outline:3px solid rgba(13,110,253,0.15); }
    @media (max-width:768px){
      .palette-collapse { position:sticky; top:0; z-index:1020; }
      .floating-submit { position:fixed; bottom:16px; left:16px; right:16px; z-index:1050; }
      .option-label { font-size: .95rem; }
    }
    @media (min-width:769px){
      .top-palette { display:flex; justify-content:center; padding:.75rem 0; }
    }
    .progress-compact { height:8px; border-radius:6px; overflow:hidden; background:#e9ecef; }
    .progress-compact > .bar { height:100%; background:linear-gradient(90deg,var(--primary),#2b8cff); width:0%; transition:width .2s ease; }
    .header-image { max-height:60px; object-fit:contain; margin-right:.8rem; }
  </style>

</head>
<body class="p-3 p-md-4">

<div class="container">

  <!-- Header: optional UI reference image + title -->
  <div class="d-flex align-items-center mb-3">
    {{-- optional reference image you uploaded (local path) --}}
    <img src="/mnt/data/a98632f4-75d6-4ca2-9ad2-d560cf1eeccb.png" alt="UI" class="header-image d-none d-md-block">
    <div class="flex-grow-1">
      <h3 class="mb-0">{{ $test->title }}</h3>
      <small class="text-muted">Total Questions: {{ $test->testQuestions->count() }} • Duration: {{ $test->duration }} minutes</small>
    </div>

    <div class="ms-3 text-end">
      <div class="timer-box" id="timerBox">
        <span id="time">--:--</span>
      </div>
      <small class="d-block mt-1 text-muted">Time Left</small>
    </div>
  </div>

  {{-- Top collapsible palette (mobile-first) --}}
  <div class="accordion mb-3 palette-collapse" id="paletteAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="panelsStayOpen-headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paletteCollapse" aria-expanded="false" aria-controls="paletteCollapse">
          Question Palette
          <span class="badge bg-secondary ms-2" id="answeredCount">0</span>
          <small class="text-muted ms-2" id="markedCountWrap">(Marked: 0)</small>
          <div class="ms-3 d-none d-md-inline-block"><small class="text-muted">Tap a number to jump</small></div>
        </button>
      </h2>
      <div id="paletteCollapse" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
        <div class="accordion-body py-3">
          <div class="palette-wrap" id="paletteWrap">
            {{-- JS will render palette items here --}}
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Progress bar --}}
  <div class="mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div><small class="text-muted" id="progressText">0 / {{ $test->testQuestions->count() }} answered</small></div>
      <div><small class="text-muted" id="markedText">0 marked</small></div>
    </div>
    <div class="progress-compact">
      <div class="bar" id="progressBar"></div>
    </div>
  </div>

  {{-- Test form: keep names exactly as your existing app expects --}}
  <form method="POST" action="{{ route('student.test.submit', $test->id) }}" id="testForm">
    @csrf

    {{-- Questions list (rendered fully like existing page) --}}
    @foreach($test->testQuestions as $index => $tq)
      @php
        $q = $tq->question;
        $qid = $q->id;
        $anchor = "q-{$qid}";
      @endphp

      <div class="card p-3 mb-3 question-card" id="{{ $anchor }}" data-index="{{ $index }}">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <strong>Q{{ $index + 1 }}.</strong>
            <span class="ms-2">{!! $q->question !!}</span>
          </div>
          <div class="text-end">
            <div class="small text-muted">Question {{ $index+1 }} / {{ $test->testQuestions->count() }}</div>
            <div class="form-check form-switch mt-2">
              <input class="form-check-input mark-switch" type="checkbox" id="mark_{{ $qid }}" data-qid="{{ $qid }}">
              <label class="form-check-label small" for="mark_{{ $qid }}">Mark for review</label>
            </div>
          </div>
        </div>

        <div class="mt-2">
          {{-- original radio inputs kept, names same as before --}}
          <input type="radio" class="option-input d-none" name="ans[{{ $qid }}]" id="q{{ $qid }}_op1" value="op_1">
          <label for="q{{ $qid }}_op1" class="option-label d-block mb-2">A) {{ $q->op_1 }}</label>

          <input type="radio" class="option-input d-none" name="ans[{{ $qid }}]" id="q{{ $qid }}_op2" value="op_2">
          <label for="q{{ $qid }}_op2" class="option-label d-block mb-2">B) {{ $q->op_2 }}</label>

          <input type="radio" class="option-input d-none" name="ans[{{ $qid }}]" id="q{{ $qid }}_op3" value="op_3">
          <label for="q{{ $qid }}_op3" class="option-label d-block mb-2">C) {{ $q->op_3 }}</label>

          <input type="radio" class="option-input d-none" name="ans[{{ $qid }}]" id="q{{ $qid }}_op4" value="op_4">
          <label for="q{{ $qid }}_op4" class="option-label d-block mb-2">D) {{ $q->op_4 }}</label>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
          <div>
            <button type="button" class="btn btn-outline-secondary btn-sm prev-btn">Previous</button>
            <button type="button" class="btn btn-primary btn-sm next-btn">Next</button>
          </div>
          <div class="small text-muted">Question ID: {{ $qid }}</div>
        </div>
      </div>
    @endforeach

    {{-- Keep original single submit button as fallback (hidden on mobile) --}}
    <div class="d-none d-md-block">
      <button type="submit" class="btn btn-success w-100 mt-2" id="submitFullBtn">Submit Test</button>
    </div>

    {{-- Hidden: we will provide a floating mobile submit --}}
  </form>

  {{-- Floating submit for mobile & quick access --}}
  <div class="floating-submit d-md-none">
    <button class="btn btn-success w-100" id="floatingSubmit">Submit Test</button>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function(){
  // Basic data from server
  const testId = "{{ $test->id }}";
  const totalQuestions = {{ $test->testQuestions->count() }};
  const durationMinutes = {{ $test->duration }};
  const LOCAL_PREFIX = "lms_test_{{ $test->id }}_"; // keep unique per test

  // Timer logic (client-side). Because controller doesn't set a session end time, we use start moment now.
  // Save start timestamp to localStorage so reload doesn't reset timer (best-effort).
  let startKey = LOCAL_PREFIX + "started_at";
  let endKey = LOCAL_PREFIX + "end_at";

  if (!localStorage.getItem(startKey)) {
    const startTs = Date.now();
    const endTs = startTs + durationMinutes * 60 * 1000;
    localStorage.setItem(startKey, startTs);
    localStorage.setItem(endKey, endTs);
  }

  function getRemainingSeconds() {
    const end = parseInt(localStorage.getItem(endKey), 10);
    return Math.max(0, Math.floor((end - Date.now())/1000));
  }

  // Render timer
  const timerEl = document.getElementById("time");
  let remaining = getRemainingSeconds();
  function formatTime(s) {
    const mm = Math.floor(s/60), ss = s % 60;
    return String(mm).padStart(2,"0") + ":" + String(ss).padStart(2,"0");
  }
  timerEl.innerText = formatTime(remaining);

  const timerInterval = setInterval(()=> {
    remaining = getRemainingSeconds();
    timerEl.innerText = formatTime(remaining);
    if (remaining <= 10) {
      document.getElementById('timerBox').classList.add('bg-warning');
      document.getElementById('timerBox').classList.remove('bg-danger');
    }
    if (remaining <= 0) {
      clearInterval(timerInterval);
      // Auto-submit when time is over
      alert("Time is up — submitting the test now.");
      submitForm();
    }
  }, 1000);

  // Single-tab lock (prevents opening same test in another tab)
  const tabKey = LOCAL_PREFIX + "active_tab";
  const myTabId = Math.random().toString(36).slice(2);
  const existing = localStorage.getItem(tabKey);
  if (existing && existing !== myTabId) {
    // If another tab exists, redirect user (or show message)
    alert("This test is already open in another tab. Please continue there.");
    window.location.href = "{{ route('user') }}"; // redirect to user landing (adjust if needed)
  } else {
    localStorage.setItem(tabKey, myTabId);
  }
  window.addEventListener("beforeunload", ()=> {
    // release lock on unload
    if (localStorage.getItem(tabKey) === myTabId) localStorage.removeItem(tabKey);
  });

  // Build palette
  const paletteWrap = document.getElementById("paletteWrap");
  const paletteItems = [];
  for (let i=0;i<totalQuestions;i++){
    const item = document.createElement('div');
    item.className = 'palette-item';
    item.dataset.index = i;
    item.innerText = i+1;
    paletteWrap.appendChild(item);
    paletteItems.push(item);

    // click jumps to question
    item.addEventListener('click', ()=> {
      // find question card by index
      const card = document.querySelector('.question-card[data-index="'+i+'"]');
      if (card) card.scrollIntoView({behavior:'smooth', block:'center'});
      setCurrent(i);
    });
  }

  // Helpers for localStorage status keys
  function answerKey(qid){ return LOCAL_PREFIX + "ans_" + qid; }
  function markedKey(qid){ return LOCAL_PREFIX + "marked_" + qid; }
  function visitedKey(qid){ return LOCAL_PREFIX + "visited_" + qid; }

  // Initialize: populate radios from localStorage (auto-restore)
  const questionCards = document.querySelectorAll('.question-card');
  questionCards.forEach((card, idx) => {
    const qid = card.id.replace("q-","");
    const savedAns = localStorage.getItem(answerKey(qid));
    if (savedAns) {
      // check corresponding input if exists
      const input = card.querySelector('input[type="radio"][value="'+savedAns+'"]');
      if (input) input.checked = true;
    }
    // mark switch init
    const markSwitch = card.querySelector('.mark-switch');
    if (markSwitch) {
      const marked = localStorage.getItem(markedKey(qid)) === "1";
      markSwitch.checked = marked;
      updatePaletteItem(idx, qid);
      // attach change handler
      markSwitch.addEventListener('change', function(){
        localStorage.setItem(markedKey(qid), this.checked ? "1" : "0");
        updatePaletteItem(idx, qid);
        refreshCounts();
      });
    }

    // visited flag
    if (!localStorage.getItem(visitedKey(qid))) {
      localStorage.setItem(visitedKey(qid), "1");
    }

    // attach radio change auto-save: selects labels are clickable; inputs are hidden, so listen change
    const radios = card.querySelectorAll('input[type="radio"]');
    radios.forEach(r => {
      r.addEventListener('change', function(){
        localStorage.setItem(answerKey(qid), this.value);
        updatePaletteItem(idx, qid);
        refreshCounts();
      });
    });

    // attach prev/next handlers
    const prevBtn = card.querySelector('.prev-btn');
    const nextBtn = card.querySelector('.next-btn');
    if (prevBtn) prevBtn.addEventListener('click', ()=> { const target = Math.max(0, idx-1); goToQuestion(target); });
    if (nextBtn) nextBtn.addEventListener('click', ()=> { const target = Math.min(totalQuestions-1, idx+1); goToQuestion(target); });
  });

  // update single palette item style based on answered/marked status
  function updatePaletteItem(index, qid) {
    const el = paletteItems[index];
    const answered = !!localStorage.getItem(answerKey(qid));
    const marked = localStorage.getItem(markedKey(qid)) === "1";
    el.classList.remove('answered','marked','current');
    if (answered) el.classList.add('answered');
    if (marked) el.classList.add('marked');
  }

  // set currently visible question
  let currentIndex = 0;
  function setCurrent(i){
    currentIndex = i;
    paletteItems.forEach(x => x.classList.remove('current'));
    if (paletteItems[i]) paletteItems[i].classList.add('current');
    // update progress
    updateProgress();
  }

  function goToQuestion(i){
    const card = document.querySelector('.question-card[data-index="'+i+'"]');
    if (card) {
      card.scrollIntoView({behavior:'smooth', block:'center'});
      setCurrent(i);
      // mark visited
      const qid = card.id.replace("q-","");
      if (!localStorage.getItem(visitedKey(qid))) localStorage.setItem(visitedKey(qid),"1");
    }
  }

  // progress calculation
  function updateProgress(){
    let answered = 0, marked = 0;
    questionCards.forEach((card, idx) => {
      const qid = card.id.replace("q-","");
      if (localStorage.getItem(answerKey(qid))) answered++;
      if (localStorage.getItem(markedKey(qid)) === "1") marked++;
      updatePaletteItem(idx, qid);
    });
    const pct = Math.round((answered / totalQuestions) * 100);
    document.getElementById('progressBar').style.width = pct + "%";
    document.getElementById('progressText').innerText = answered + " / " + totalQuestions + " answered";
    document.getElementById('markedText').innerText = marked + " marked";
    document.getElementById('answeredCount').innerText = answered;
    document.getElementById('markedCountWrap').innerText = "(Marked: " + marked + ")";
  }

  // initial set
  setCurrent(0);
  updateProgress();

  // when user scrolls, find nearest question and set current
  let scrollTimer;
  window.addEventListener('scroll', ()=> {
    clearTimeout(scrollTimer);
    scrollTimer = setTimeout(()=> {
      let nearest = 0, minDist = Infinity;
      questionCards.forEach((card, i) => {
        const rect = card.getBoundingClientRect();
        const dist = Math.abs(rect.top - window.innerHeight/4);
        if (dist < minDist) { minDist = dist; nearest = i; }
      });
      setCurrent(nearest);
    }, 120);
  });

  // floating submit handler (gathers localStorage answers and injects into form)
  document.getElementById('floatingSubmit').addEventListener('click', submitForm);
  const desktopSubmit = document.getElementById('submitFullBtn');
  if (desktopSubmit) desktopSubmit.addEventListener('click', beforeSubmit);

  function beforeSubmit(e) {
    // called if using desktop submit (normal button)
    // we let the form submit normally after injecting answers
    injectSavedAnswersToForm();
  }

  function submitForm(){
    injectSavedAnswersToForm();
    document.getElementById('testForm').submit();
  }

  // inject all saved answers into the form by creating hidden inputs for any missing ones
  function injectSavedAnswersToForm(){
    questionCards.forEach(card => {
      const qid = card.id.replace("q-","");
      const saved = localStorage.getItem(answerKey(qid));
      if (saved) {
        // try to set actual radio if exists
        const input = card.querySelector('input[type="radio"][value="'+saved+'"]');
        if (input) {
          input.checked = true;
        } else {
          // fallback: create hidden input with the same name as server expects: ans[qid] => value
          const existingHidden = card.querySelector('input[type="hidden"][name="ans['+qid+']"]');
          if (!existingHidden) {
            const h = document.createElement('input');
            h.type = 'hidden';
            h.name = 'ans['+qid+']';
            h.value = saved;
            card.appendChild(h);
          } else {
            existingHidden.value = saved;
          }
        }
      }
      // ensure marked value also submitted if you want server to see it:
      // create hidden input name="marked[qid]" value="1"
      const markedVal = localStorage.getItem(markedKey(qid)) === "1" ? "1" : "0";
      let hiddenMark = card.querySelector('input[type="hidden"][name="marked['+qid+']"]');
      if (!hiddenMark) {
        hiddenMark = document.createElement('input');
        hiddenMark.type = 'hidden';
        hiddenMark.name = 'marked['+qid+']';
        card.appendChild(hiddenMark);
      }
      hiddenMark.value = markedVal;
    });
  }

  // periodic auto-save to localStorage (already done on change, but safe-guard)
  setInterval(()=> {
    // no-op heavy task; we can refresh counts
    updateProgress();
  }, 2000);

  // Optional: keyboard navigation (n / p)
  window.addEventListener('keydown', (e)=> {
    if (e.key === 'n' || e.key === 'ArrowRight') {
      goToQuestion(Math.min(totalQuestions-1, currentIndex+1));
    } else if (e.key === 'p' || e.key === 'ArrowLeft') {
      goToQuestion(Math.max(0, currentIndex-1));
    }
  });

  // initial scroll to top question if an anchor is provided by URL (optional)
  const urlHash = window.location.hash;
  if (urlHash.startsWith("#q-")) {
    const el = document.querySelector(urlHash);
    if (el) el.scrollIntoView({behavior:'smooth', block:'center'});
  }

  // final: when form submitted, optionally clear localStorage keys for this test
  document.getElementById('testForm').addEventListener('submit', function(){
    // clear only if you want; comment out if you want to keep answers
    try {
      for (let i=0;i<totalQuestions;i++){
        const card = questionCards[i];
        if (!card) continue;
        const qid = card.id.replace("q-","");
        localStorage.removeItem(answerKey(qid));
        localStorage.removeItem(markedKey(qid));
        localStorage.removeItem(visitedKey(qid));
      }
      localStorage.removeItem(startKey);
      localStorage.removeItem(endKey);
      localStorage.removeItem(tabKey);
      localStorage.removeItem(LOCAL_PREFIX + "ans_cleaned"); // optional marker
    } catch(e){ console.warn(e); }
  });

})();
</script>

</body>
</html>
