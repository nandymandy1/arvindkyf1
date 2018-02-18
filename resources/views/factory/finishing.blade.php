@extends('layouts.app')

@section('css')

{!! Charts::styles() !!}

@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
      <h3 class="page-heading mb-4">Finishing</h3>
  </div>
  <div class="col-md-6">
    <button type="button" class="btn btn-md btn-primary pull-right" id="add" name="button" data-toggle="modal" data-target="#finishingModal">Add Today's Data</button>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        {!! $charts[0]->html() !!}
      </div>
    </div>
  </div>
</div>
</div>
<!-- partial:../../partials/_footer.html -->


@endsection


@section('scripts')

  {!! Charts::scripts() !!}
  {!! $charts[0]->script() !!}

<script type="text/javascript">
  $(document).ready(()=>{


    // Form subimssion method goes Here
    $('#add').click(() => {
      $('#finishing_form')[0].reset();
      $('#form-output').html('');
      $('#add_data').val('Add');
    });

    $('#finishing_form').on('submit', (event) => {
      event.preventDefault();
      $.ajax({
        url:"{{route('ajaxdata.postfinishing')}}",
        method: "POST",
        data: $('#finishing_form').serialize(),
        dataType: "json",
        success: (data) => // Success CallBack function
            {
              // console.log(data.error);
              if(data.error.length > 0)
              {
                  var error_html = '';
                  for(var i= 0; i< data.error.length; i++)
                  {
                    error_html += '<div class="alert alert-danger">'+data.error[i]+'</div>';
                  }
                  // console.log(error_html);
                  $('#form_output').html(error_html);
              }
              else
              {
                $('#form_output').html(data.success);
                $('#finishing_form')[0].reset();
                $('#add_data').val('Add');
                $('.modal_title').text('Add Today\'s Finishing Data');
              }
            }
      });
    });



  });
</script>


@endsection




<!--Add Cutting Modal Goes Here-->
<!-- Modal -->
<div class="modal fade" id="finishingModal" tabindex="-1" role="dialog" aria-labelledby="finishingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Today's Finishing Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms" method="post" id="finishing_form">
          {{ csrf_field() }}
          <span id="form_output"></span>
          <input type="hidden" name="factory_id" value="{{Auth::user()->factory_id}}">

          <div class="form-group">
          <label for="pcs_r_s">Number of Pieces recieved from sewing or washing</label>
          <input type="number" id="pcs_r_s" name="pcs_sew_wash" class="form-control p-input" placeholder="Pieces Recieved From Sewing">
        </div>
        <div class="form-group">
          <label for="pcs_f_f">Number of pieces fed in finishing</label>
          <input type="number" id="pcs_f_f" name="pcs_fed" class="form-control p-input" placeholder="Piesces Fed">
        </div>
        <div class="form-group">
          <label for="pkd_pcs">Number of Packed Pieces</label>
          <input type="number" id="pkd_pcs" name="pkd_pcs" class="form-control p-input" placeholder="Packed Pieces">
        </div>

      </div>
      <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <input type="submit" class="btn btn-primary" id="add_data" value="Add">
  </div>
</form>
</div>
</div>
</div>
