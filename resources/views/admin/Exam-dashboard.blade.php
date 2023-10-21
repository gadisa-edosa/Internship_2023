@extends('layout/admin-layout')
@section('space-work')
    <h2 class="mb-4">Exam</h2><!-- Button trigger modal -->

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModel">
        Add Exam
    </button>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Exam Name</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Time</th>
                <th>Attempt</th>
                <th>Add Question</th>
                <th>Show Question</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if (count($exams) > 0)
                    @foreach ($exams as $exam)
            <tr>
                <td>{{ $exam->id }}</td>
                <td>{{ $exam->exam_name }}</td>
                <td>{{ $exam->subjects[0]['subject'] }}</td>
                <td>{{ $exam->date }}</td>
                <td>{{ $exam->time }}Hrs</td>
                <td>{{ $exam->attempt }}Time</td>
                <td>
                    <button type="button" class="addQuestion" data-id="{{ $exam->id }}" data-toggle="modal"
                        data-target="#addQnaModal">Add Question</button>
                </td>
                <td>
                    <a href="#" class="seeQuestions" data-id="{{ $exam->id }}" data-toggle="modal"
                        data-target="#seeQnaModal">See Question</a>
                </td>
                <td>
                    <button class="btn btn-info editButton" data-id="{{ $exam->id }}" data-toggle="modal"
                        data-target="#editExamModel">Edit </button>
                </td>
                <td>
                    <button class="btn btn-danger deleteButton" data-id="{{ $exam->id }}" data-toggle="modal"
                        data-target="#deleteExamModel">Delete </button>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">Exam not Found!</td>
            </tr>
            @endif
            </tr>
        </tbody>

    </table>



    <!-- Add Exam Modal -->
    <div class="modal fade" id="addExamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addExam">
                    @csrf
                    <div class="modal-body">
                        <label>Exam</label>
                        <input type="text" name="exam_name" placeholder="Enter Exam name" class="w-100"
                            required><br><br>
                        <select name="subject_id" id="" required class="w-100">
                            <option value="">Select Subject</option>
                            @if (count($subjects) > 0)
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                @endforeach
                            @endif

                        </select>
                        <br><br>
                        <input type="date" name="date" class="w-100" requireds
                            min="@php
echo date('Y-m-d'); @endphp"><br><br>
                        <input type="time" name="time" class="w-100" requireds>
                        <br><br>
                        <input type="number" name="attempt" min="1" id="attempt"
                            placeholder="Enter attempt Exam Time" class="w-100" requireds>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Exam</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- edit Quiz Modal -->
    <div class="modal fade" id="editExamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editExam">
                    @csrf
                    <div class="modal-body">
                        <label>Exam</label>
                        <input type="text" name="exam_name" id="exam_name" placeholder="Enter Exam name" class="w-100"
                            id="edit_exam" required><br><br>
                        <input type="hidden" name="exam_id" id="exam_id">
                        <select name="subject_id" id="subject_id" required class="w-100">
                            <option value="">Select Subject</option>
                            @if (count($subjects) > 0)
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                @endforeach
                            @endif

                        </select>
                        <br><br>
                        <input type="date" name="date" id="date" class="w-100" requireds
                            min="@php
echo date('Y-m-d'); @endphp">
                        <br><br>
                        <input type="time" name="time" id="time" class="w-100" requireds>
                        <br><br>
                        <input type="number" name="attempt" min="1" id="attempt"
                            placeholder="Enter attempt Exam Time" class="w-100" requireds>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
            </div>
            </form>
        </div>
    </div>


    <!-- delete Exam Modal -->
    <div class="modal fade" id="deleteExamModel" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteExam">
                    @csrf
                    <div class="modal-body">
                        <label>Exam</label>
                        <input type="hidden" name="exam_id" id="deleteExamId">
                        <p>are sure you want to Delete the Exam?</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">delete</button>
                    </div>
            </div>
            </form>
        </div>
    </div>


    <!-- Add question Modal -->
    <div class="modal fade" id="addQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Q&A</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addQna">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="addExamId">
                        <input type="search" name="search" id="search" onkeyup="searchTable()" class="w-100"
                            placeholder="search here">
                        <br><br>
                        <table class="table" id="questionsTable">
                            <thead>
                                <th>Select</th>
                                <th>Question</th>
                            </thead>
                            <tbody class="addBody"></tbody>
                        </table>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Question</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <!-- Show question Modal -->
    <div class="modal fade" id="seeQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Questions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="seeQna">
                    @csrf
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <th>S.No</th>
                                <th>Questions</th>
                                <th>Delete</th>
                            </thead>
                            <tbody class="seeQuestionTable">

                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("#addExam").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('addExam') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });

            });

            // Handle AJAX request for editing an exam
            $(".editButton").click(function() {
                var id = $(this).attr('data-id');
                $("#exam_id").val(id);
                var url = $(this).attr('data-url');

                url = url.replace('id', id);
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        if (data.success == true) {
                            var exam = data.data;
                            $("#exam_name").val(exam[0].exam_name);
                            $("#subject_id").val(exam[0].subject_id);
                            $("#date").val(exam[0].date);
                            $("#time").val(exam[0].time);
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            // Handle AJAX request for updating an exam
            $("#editExam").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('editExam') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            // Handle AJAX request for deleting an exam
            $(".deleteButton").click(function() {
                var id = $(this).attr('data-id');
                $("#deleteExamId").val(id);
            });

            $("#deleteExam").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('deleteExam') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //add questions part
            $('.addQuestion').click(function() {

                var id = $(this).attr('data-id');
                $('#addExamId').val(id);

                $.ajax({
                    url: "{{ route('getQuestions') }}",
                    type: "GET",
                    data: {
                        exam_id: id
                    },
                    success: function(data) {
                        if (data.success == true) {

                            var questions = data.data;
                            var html = '';
                            if (questions.length > 0) {
                                for (let i = 0; i < questions.length; i++) {
                                    html += `
                            <tr>
                                <td><input type="checkbox" value="` + questions[i]['id'] + `" name="questions_ids[]"></td>
                                <td>` + questions[i]['questions'] + `</td>
                            </tr>`;
                                }
                            } else {
                                html += `
                      <tr>
                          <td colspan="2">Question is not Available!</td>
                      </tr> `;
                            }
                            $('.addBody').html(html);
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });
            $("#addQna").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('addQuestions') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });
            //see questions part


            $('.seeQuestions').click(function() {
                var id = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('getExamQuestions') }}",
                    type: "GET",
                    data: {
                        exam_id: id
                    },
                    success: function(data) {
                        console.log(data);

                        var questions = data.data;
                        console.log(questions);

                        var html = '';
                        if (questions.length > 0) {
                            for (let i = 0; i < questions.length; i++) {
                                html += `
                <tr>
                  <td>` + (i + 1) + `</td>
                  <td>` + questions[i]['question'][0]['question'] + `</td>
                  <td>
                    <button class="btn btn-danger deleteQuestion" data-id="` + questions[i]['id'] + `">Delete</button>
                  </td>
                </tr>
              `;
                            }
                        } else {
                            html += `
              <tr>
                <td colspan="1">Question is not Available!</td>
              </tr>
            `;
                        }
                        $('.seeQuestionTable').html(html);
                    }
                });
            });


            $(document).on('click', '.deleteQuestion', function() {
                var id = $(this).attr('data-id');
                var obj = $(this);
                $.ajax({
                    url: "{{ route('deleteExamQuestions') }}",
                    type: "GET",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data.success == true) {
                            obj.parent().parent().remove();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

        });
    </script>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('search');
            filter = input.value.toUpperCase();
            table = document.getElementById('questionsTable');
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>


@endsection
