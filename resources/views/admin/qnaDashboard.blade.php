@extends('layout/admin-layout')

@section('space-work')
    <h2 class="mb-4">Q&A</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQnaModel">
        Add Q&A
    </button>
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#importQnaModel">
        import Q&A
    </button>
    <table class="table">
        <thead>
            <th>#</th>
            <th>Question</th>
            <th>Answers</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
            @if (count($questions) > 0)
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question }}</td>
                        <td>
                            <a href="#" class="ansButton" data-id="{{ $question->id }}" data-toggle="modal"
                                data-target="#showAnsModel">See Answers</a>
                        </td>
                        <td>
                            <button class="btn btn-info editButton" data-question="{{ $question->question }}"
                                data-id="{{ $question->id }}" data-toggle="modal" data-target="#editQnaModel">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{ $question->id }}" data-toggle="modal"
                                data-target="#deleteQnaModel">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Question & Answers not found!</td>
                </tr>
            @endif
        </tbody>

    </table>

    <!-- add Qna Modal -->
    <div class="modal fade" id="addQnaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Q&A</h5>
                    <button id="addAnswer" class="ml-5 btn btn-info">Add Answer</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addQna">
                    @csrf
                    <div class="modal-body addModalAnswers">
                        <div class="row ">
                            <div class="col">
                                <input type="text" name="question" class="w-100" placeholder="Enter Question" required>
                            </div>
                        </div>
                    </div>

                    <div class="row  mt-2">
                        <div class="col">
                            <textarea name="explanation" class="w-100" placeholder="Enter your Explanation(optional)"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <span class="error" style="color: red;"></span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Q&A</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- edit Qna Modal -->
    <div class="modal fade" id="editQnaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">update Q&A</h5>
                    <button id="addEditAnswer" class="ml-5 btn btn-info">Add Answer</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editQna">
                    @csrf
                    <div class="modal-body editModalAnswers">
                        <div class="row ">
                            <div class="col">
                                <input type="hidden" name="question_id" id="question_id">
                                <input type="text" name="question" id="question" class="w-100"
                                    placeholder="Enter Question" required>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col">
                            <textarea name="explanation" id="explanation" class="w-100" placeholder="Enter your explanation(optional)"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <span class="editError" style="color: red;"></span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">update Q&A</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- show Exam Modal -->
    <div class="modal fade" id="showAnsModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">show Answers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Answer</th>
                        <th>Is Correct</th>
                    </thead>
                    <tbody class="showAnswers">

                    </tbody>

                </table>

                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <span class="error" style="color: red;"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!-- import Q&A Modal -->
    <div class="modal fade" id="importQnaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Import Q&A</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="importQna" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" name="file" id="fileupload" required
                            accept=".csv,application/vnd.openxmlformats.officedocument.spreadsheetml.sheet, application/vnd.ms.excel">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">import Q&A</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Edit deleteButton -->
    <div class="modal fade" id="deleteQnaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Q&A</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteQna">
                    @csrf
                    <div class="modal-body">
                        <label>Exam</label>
                        <input type="hidden" name="id" id="delete_qna_id">
                        <p>are sure you want to Delete the Q&A?</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">delete</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // form submission
            $("#addQna").submit(function(e) {
                e.preventDefault();
                if ($(".answers").length < 2) {
                    $(".error").text("please add minimum two answers");
                    setTimeout(function() {
                        $(".error").text("");
                    }, 2000);
                } else {
                    var checkIsCorrect = false;
                    for (let i = 0; i < $(".is_correct").length; i++) {
                        if ($(".is_correct:eq(" + i + ")").prop("checked")) {
                            checkIsCorrect = true;
                            $(".is_correct:eq(" + i + ")").val($(".is_correct:eq(" + i + ")").next().find(
                                "input").val());
                        }
                    }
                    if (checkIsCorrect) {
                        var formData = $(this).serialize();
                        $.ajax({
                            url: "{{ route('addQna') }}",
                            type: "POST",
                            data: formData,
                            success: function(data) {
                                console.log(data);
                                if (data.success == true) {
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }
                            }
                        });
                    } else {
                        $(".error").text("please select one correct answer");
                        setTimeout(function() {
                            $(".error").text("");
                        }, 2000);
                    }
                }
            });


            // add answer
            $(document).on("click", "#addAnswer", function() {
                if ($(".answers").length >= 6) {
                    $(".error").text("you can add maximum 6 answers");
                    setTimeout(function() {
                        $(".error").text("");
                    }, 2000);
                } else {
                    var html = '<div class="row mt-2 answers">' +
                        '<input type="radio" name="is_correct" class="is_correct" />' +
                        '<div class="col">' +
                        '<input type="text" name="answers[]" class="w-100" placeholder="Enter answer" required>' +
                        '</div>' +
                        '<button class="btn btn-danger removeButton">Remove</button>' +
                        '</div>';
                    $(".addModalAnswers").append(html);
                }
            });

            // remove answer
            $(document).on("click", ".removeButton", function() {
                $(this).parent().remove();
            });
            //show answer code
            $(".ansButton").click(function() {
                var questions = @json($questions);
                var qid = $(this).attr('data-id');
                var html = '';
                console.log(questions);
                for (let i = 0; i < questions.length; i++) {
                    if (questions[i]['id'] == qid) {
                        var answerslength = questions[i]['answers'].length;
                        for (let j = 0; j < answerslength; j++) {
                            let is_correct = (questions[i]['answers'][j]['is_correct'] == 1) ? "Yes" : "No";
                            html += `
                    <tr>
                        <td>${j + 1}</td>
                        <td>${questions[i]['answers'][j]['answer']}</td>
                        <td>${is_correct}</td>
                    </tr>
                `;
                        }
                        break;
                    }
                }
                $(".showAnswers").append(html);
            });

            // edit or update answer
            $(document).on("click", "#addEditAnswer", function() {
                if ($(".editanswers").length >= 6) {
                    $(".editError").text("you can add maximum 6 answers");
                    setTimeout(function() {
                        $(".editError").text("");
                    }, 2000);
                } else {
                    var html = '<div class="row mt-2 editAnswers">' +
                        '<input type="radio" name="is_correct" class="edit_is_correct" />' +
                        '<div class="col">' +
                        '<input type="text" name="new_answers[]" class="w-100" placeholder="Enter answer" required>' +
                        '</div>' +
                        '<button class="btn btn-danger removeButton">Remove</button>' +
                        '</div>';
                    $(".editModalAnswers").append(html);
                }
            });


            //no

            $(".editButton").click(function() {
                var qid = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('getQnaDetails') }}",
                    type: "GET",
                    data: {
                        qid: qid
                    },
                    success: function(data) {
                        console.log(data);
                        var qna = data.data[0];
                        $("#question_id").val(qna['id']);
                        $("#question").val(qna['question']);
                        $(".editAnswers").remove();
                        $("#explanation").val(qna['explanation']);
                        var html = '';
                        for (let i = 0; i < qna['answers'].length; i++) {
                            var checked = '';
                            if (qna['answers'][i]['is_correct'] == 1) {
                                checked = 'checked';
                            }
                            html += '<div class="row mt-2 editAnswers">' +
                                '<input type="radio" name="is_correct" class="edit_is_correct" ' +
                                checked + '/>' +
                                '<div class="col">' +
                                '<input type="text" name="answers[' + qna['answers'][i]['id'] +
                                ']" class="w-100" placeholder="Enter answer" value="' + qna[
                                    'answers'][i]['answer'] + '" required>' +
                                '</div>' +
                                '<button class="btn btn-danger removeButton removeAnswers">Remove</button>' +
                                '</div>';
                        }
                        $(".editModalAnswers").append(html);
                    }
                });
            });




            $("#editQna").submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting normally

                // Check if there are at least two answer options
                if ($(".editAnswers").length < 2) {
                    $(".editError").text("please add minimum two answers");
                    setTimeout(function() {
                        $(".editError").text("");
                    }, 2000);
                } else {
                    var checkIsCorrect = false;

                    // Loop through each answer option to check if it is marked as correct
                    for (let i = 0; i < $(".edit_is_correct").length; i++) {
                        if ($(".edit_is_correct:eq(" + i + ")").prop("checked")) {
                            checkIsCorrect = true;
                            $(".edit_is_correct:eq(" + i + ")").val($(".edit_is_correct:eq(" + i + ")")
                                .next().find("input").val());
                        }
                    }

                    // If a correct answer is selected
                    if (checkIsCorrect) {
                        var formData = $(this).serialize();

                        // Make an AJAX request to update the question and answers
                        $.ajax({
                            url: "{{ route('updateQna') }}",
                            type: "POST",
                            data: formData,
                            success: function(data) {
                                if (data.success == true) {
                                    location
                                        .reload(); // Reload the page after successful update
                                } else {
                                    alert(data
                                        .msg); // Display an error message if the update fails
                                }
                            }
                        });
                    } else {
                        $(".editError").text("please select one correct answer");
                        setTimeout(function() {
                            $(".editError").text("");
                        }, 2000);
                    }
                }
            });

            //remove answers
            $(document).on('click', '.removeAnswers', function() {
                var ansId = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('deleteAns') }}",
                    type: "GET",
                    data: {
                        id: ansId
                    },
                    success: function(data) {
                        if (data.success == true) {
                            console.log(data.msg);
                        } else {
                            alert(data.msg);
                        }

                    }
                });


            });



            //delete Q&A
            $(".deleteButton").click(function() {
                var id = $(this).attr('data-id');
                $('#delete_qna_id').val(id);

                $('#deleteQna').submit(function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url: "{{ route('deleteQna') }}",
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
            });


            $('#importQna').submit(function(e) {
                e.preventDefault();
                let formData = new formData();
                formData.append("file", fileupload.files[0]);
                $.ajaxsetup({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });
                $.ajax({
                    url: "{{ route('importQna') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.success == true) {
                            location: reload();

                        }
                        else {
                            alert(data.msg);
                        }
                    }
                });

            });
        });
    </script>
@endsection
