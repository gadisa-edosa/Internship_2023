@extends('layout/admin-layout')
@section('space-work')
<h2 class="mb-4">marks</h2><!-- Button trigger modal -->



<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Exam_Name</th>
            <th>Marks/Q</th>
            <th>Total marks</th>
            <th>passing marks</th>
            <th>Edit</th>


        </tr>
    </thead>
    <tbody>

        @if(count($exams) > 0)
        @php $x = 1 ;@endphp
        @foreach ($exams as $exam)
        <tr>
            <td>{{ $x++ }}</td>
            <td>{{ $exam->exam_name }}</td>
            <td>{{ $exam->marks }}</td>
            <td>{{ count($exam->getQnaExam) * $exam->marks }}</td>


        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="5">Exams not added</td>
        </tr>
        @endif

    </tbody>

</table>


<!-- Edit Marks Modal -->
<div class="modal fade" id="editMarksModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Marks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editMarks">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-4">
                            <label>Marks/Q</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" name="exam_id" id="exam_id">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label>Total marks</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" name="exam_id" id="exam_id">
                            <input type="text" onkeypress="return event.charCode >=48 && event.charCode <=57 || event.charCode == 46" name="total marks" placeholder="Enter Total marks" id="total_marks" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label>passing Marks</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" onkeypress="return event.charCode >=48 && event.charCode <=57 || event.charCode == 46" name="pass_marks" placeholder="Enter passing marks" id="pass_marks" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Marks</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        var totalQna = 0;
        $('.editMarks').click(function() {
            var exam_id = $(this).attr('data-id');
            var marks = $(this).attr('data-marks');
            var totalq = $(this).attr('data-totalq');
            $('#marks').val(marks);
            $('#exam_id').val(exam_id);
            $('#tmarks').val((marks * totalq).toFixed(1));
            totalQna = totalq;

            $('#pass_marks').val($(this).attr('data-pass-marks'));
        });
        $('#marks').keyup(function() {
            $('#tmarks').val(($(this).val() * totalQna).toFixed(1));
        });
        $('#pass_marks').keyup(function() {
            $('.pass-error').remove();
            var tmarks = $('#tmarks').val();
            var pmarks = $(this).val();
            if (parseFloat(pmarks) >= parseFloat(tmarks)) {
                $(this).parent().append('<p style="color:red;" mt-1 class="pass-error">passing marks will be less than totals marks!</p>')
                setTimeout(() => {
                    $('.pass-error').remove();

                }, 2000);
            }

        });
        $("#editMarks").submit(function(event) {
            event.preventDefault();
            $('.pass-error').remove();
            var tmarks = $('#tmarks').val();
            var pmarks = $('#pass_marks').val();
            if ('#pass_marks') >= parseFloat(tmarks) {
                $(this).parent().append('<p style="color:red;" mt-1 class="pass-error">passing marks will be less than totals marks!</p>')
                setTimeout(() => {
                    $('.pass-error').remove();

                }, 2000);
                return false;
            }
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('updateMarks') }}",
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
</script>

<script>
    /*
                    let isCorrect = '<span style="color:red;" class="fa fa-close"></span>';
                    let answer = responseData[i]['answers']['answer'];
                    if (responseData[i]['answers']['is_correct'] === 1) {
                      isCorrect = '<span style="color:green;" class="fa fa-check"></span>';
              }

            }
          } */
</script>

@endsection
