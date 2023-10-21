@extends('layout.student-layout')
@section('space-work')
    <h5>Exams</h5>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Exam Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Total attempt</th>
                <th>Available attempt</th>
                <th>Take Exam</th>
            </tr>
        </thead>
        <tbody>
            @if (count($exams) > 0)
                @php
                    $count = 1;
                @endphp
                @foreach ($exams as $exam)
                    <tr>
                        <td style="display: none;">{{ $exam->id }}</td>
                        <td>{{ $count++ }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->time }} Hrs</td>
                        <td>{{ $exam->attempt }} Time</td>
                        <td>{{ $exam->attempt_counter }}</td>
                        <td>
                            <button class="open-exam btn btn-primary" data-code="{{ $exam->enterance_id }}"> Open
                                Exam</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">No Exams Available!</td>
                </tr>
            @endif
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.open-exam').click(function() {
                var code = $(this).attr('data-code');
                var url = "{{ URL::to('/') }}/exam/" + code;
                window.location.href = url;
            });
        });
    </script>
@endsection
