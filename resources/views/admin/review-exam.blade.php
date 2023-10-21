<span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form id="reviewForm">
            @csrf
              <input type="hidden" name="attempt_id" id="attempt_id">
                <div class="modal-body review-exam">
                  Loading ...
                </div>    

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary approved-btn">Approved</button>
                </div>
        </form>
        </div>

    </div>

  <script>
    $(document).ready(function(){
      $('.reviewExam').click(function(){
        var id = $(this).attr('data_id');
        $('#attempt_id').val(id);
        $.ajax({
          url:"{{ route('reviewQna') }}",
                console.log(data);
                for(let i=0; i < data.length; i++){
                  let isCorrect = '<span style="color:red;" class="fa fa-close"></span>';
                  
                  if(data[i]['answers']['is_correct'] == 1){
                    isCorrect = '<span style="color:green;" class="fa fa-check"></span>';
                  }
                  let answer = data[i]['answers']['answer'];
                  html += `
                      <div class="row">
                        <div class="col-sm-12">
                          <h6>Q(`+(i+1)+`). `+data[i]['question']['question']+`</h6>
                          <p>Ans:- `+answer+`  `+isCorrect+` </p>
                        </div>
                      </div>
                  `;
                }
              });
              else{
                html += `<h6>Student is not attempt any questions</h6>
                         <p> if you approve this exam student will fail</p>`;
              }
            }
            else{
              html += `<p>Having some server issue!</p>`;
            }
            $('.review-exam').html(html);

        });

    
      $('#reviewForm').submit(function(event){
        event.preventDefault();
        $('.approved-btn').html('please wait <i class="fa fa-spinner fa-spin"></i>')
        var formData = $(this).serialize();
        $.ajax({
            url:"{{ route('approvedQna') }}",
            type:"POST",
            data:formData,
            success:function(data){
                if(data.success == true){
                    location.reload();
                }else{
                    alert(data.msg);
                }
            }
        });
    });
    
  </script>