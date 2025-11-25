@extends('layouts.admin')

@section('content')

<div class="card shadow-sm p-4">

  <h4 class="mb-3">All Test Results</h4>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Student</th>
          <th>Email</th>
          <th>Test</th>
          <th>Score</th>
          <th>Percentage</th>
          <th>Status</th>
        </tr>
      </thead>

      <tbody>
        @foreach($results as $i => $res)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $res->student->name ?? 'Unknown' }}</td>
          <td>{{ $res->student->email ?? '-' }}</td>
          <td>{{ $res->test->title }}</td>
          <td>{{ $res->score }}/{{ $res->total_questions }}</td>
          <td>{{ number_format($res->percentage,2) }}%</td>
          <td>
            @if($res->percentage >= 40)
              <span class="badge bg-success">Pass</span>
            @else
              <span class="badge bg-danger">Fail</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>

@endsection
