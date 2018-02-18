@extends('layouts.app')
@section('css')

{!! Charts::styles() !!}

@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
      <h3 class="page-heading mb-4">Quality and Strength</h3>
  </div>
  <div class="col-md-6">
    <button type="button" class="btn btn-md btn-primary pull-right" id="add" name="button" data-toggle="modal" data-target="#strengthModal">Add Today's Data</button>
  </div>
</div>
<div class="row" id="alert">

</div>
<div class="row">
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        {!! $charts[0]->html() !!}
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        {!! $charts[1]->html() !!}
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        {!! $charts[2]->html() !!}
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        {!! $charts[3]->html() !!}
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        {!! $charts[4]->html() !!}
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4">Scatter chart</h5>

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
  {!! $charts[1]->script() !!}
  {!! $charts[2]->script() !!}
  {!! $charts[3]->script() !!}
  {!! $charts[4]->script() !!}


<script type="text/javascript">
  $(document).ready(() => {

    // Form subimssion method goes Here
    $('#add').click(() => {
      $('#strength_form')[0].reset();
      $('#form-output').html('');
      $('#add_data').val('Add');
    });


        $('#strength_form').on('submit', (event) => {
          event.preventDefault();
          $.ajax({
            url:"{{route('ajaxdata.poststrength')}}",
            method: "POST",
            data: $('#strength_form').serialize(),
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
                    $('#alert').html(data.success);
                    $('#strength_form')[0].reset();
                    $('#add_data').val('Add');
                    $('.modal_title').text('Add Today\'s Strength Data');
                    $('#add').hide();
                  }
                }
          });
        });

  });
  </script>
@endsection

<!--Add Cutting Modal Goes Here-->
<!-- Modal -->
<div class="modal fade" id="strengthModal" tabindex="-1" role="dialog" aria-labelledby="strengthModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Today's Strength and Quality Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms" method="post" id="strength_form">
          {{ csrf_field() }}
          <span id="form_output"></span>
          <input type="hidden" name="factory_id" value="{{Auth::user()->factory_id}}">
          <div class="form-group">
            <label for="">Quality- DHU</label>
            <input type="text" name="dhu" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Quantity Inspected</label>
            <input type="text" name="inspected" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Quantities Failed</label>
            <input type="text" name="failed" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Number of people at payrole</label>
            <input type="text" name="people_payrole" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Number of people at contract</label>
            <input type="text" name="people_cont" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Overtime Pay</label>
            <input type="text" name="overtime_pay" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Cuting Overtime</label>
            <input type="text" name="ot_cut" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Sewing Overtime</label>
            <input type="text" name="ot_sew" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Finishing Overtime</label>
            <input type="text" name="ot_fin" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Number of People Absent</label>
            <input type="text" name="absent" class="form-control" value="">
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
