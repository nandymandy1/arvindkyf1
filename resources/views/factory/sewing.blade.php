@extends('layouts.app')

@section('css')

{!! Charts::styles() !!}

@endsection

@section('content')
<div class="row">
  <div class="col-md-6">
      <h3 class="page-heading mb-4">Sewing</h3>
  </div>
  <div class="col-md-6">
    <button type="button" class="btn btn-md btn-primary pull-right" id="add" name="button" data-toggle="modal" data-target="#sewingModal">Add Today's Data</button>
  </div>
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
        <h5 class="card-title mb-4">Pie chart</h5>
        <canvas id="pieChart" style="height:250px"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4">Scatter chart</h5>
        <canvas id="scatterChart" style="height:250px"></canvas>
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

<script type="text/javascript">
  $(document).ready(() => {


    // Form subimssion method goes Here
    $('#add').click(() => {
      $('#sewing_form')[0].reset();
      $('#form-output').html('');
      $('#add_data').val('Add');
    });

    // To read the value from the no. of lines box and add the new text fields
    $('#no_line').focusout( ()=> {
      var lines = $('#no_line').val();
      var input = '';
      for(var i = 1; i <= lines; i++){
        input += 'Line '+ i +': <input type="text" class="form-control" name="line'+ i +'" value="">';
      }

      $('#dynamic').html(input);
    });


    $('#sewing_form').on('submit', (event) => {
      event.preventDefault();

      $.ajax({
        url: "{{route('ajaxdata.postsewing')}}",
        method: "POST",
        data: $("#sewing_form").serialize(),
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
                $('#sewing_form')[0].reset();
                $('#add_data').val('Add');
                $('.modal_title').text('Add Today\'s Sewing Data');
              }
            }
          });
        });

});



</script>


@endsection



<!--Add Cutting Modal Goes Here-->
<!-- Modal -->
<div class="modal fade" id="sewingModal" tabindex="-1" role="dialog" aria-labelledby="sewingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Today's Sewing Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms" id="sewing_form">
          <span id="form_output"></span>
          <input type="hidden" name="factory_id" value="{{Auth::user()->factory_id}}">
          <div class="form-group">
            <label for="">Number of pieces loaded from cutting</label>
            <input type="text" class="form-control" id="" name="no_load" value="">
          </div>
          <div class="form-group">
            <label for="">No. of lines</label>
            <input type="text" class="form-control" id="no_line" name="no_line" value="">
          </div>
          <div class="form-group" id="dynamic">

          </div>
          <div class="form-group">
            <label for="">Total sewing output</label>
            <input type="text" class="form-control" id="" name="so_pl" value="">
          </div>
          <div class="form-group">
            <label for="">Today's Target Production</label>
            <input type="text" class="form-control" id="" name="target" value="">
          </div>
          <div class="form-group">
            <label for="">Today's Actual Production</label>
            <input type="text" class="form-control" id="" name="actual" value="">
          </div>
          <div class="form-group">
            <label for="">Number of sewing machines Used</label>
            <input type="text" class="form-control" id="" name="no_sew_mcs" value="">
          </div>
          <div class="form-group">
            <label for="">Number of people in sewing department</label>
            <input type="text" class="form-control" id="" name="no_people" value="">
          </div>
          <div class="form-group">
            <label for="">Number of sewing operators</label>
            <input type="text" class="form-control" id="" name="no_opr" value="">
          </div>
          <div class="form-group">
            <label for="">Number of helpers</label>
            <input type="text" class="form-control" id="" name="no_help" value="">
          </div>
          <div class="form-group">
            <label for="">Number of Kaja operators</label>
            <input type="text" class="form-control" id="" name="no_kaja" value="">
          </div>
          <div class="form-group">
            <label for="">SAM</label>
            <input type="text" class="form-control" id="" name="sam" value="">
          </div>
          <div class="form-group">
            <label for="">Number of pieces sent for finishing or washing</label>
            <input type="text" class="form-control" id="" name="no_send" value="">
          </div>
          {{ csrf_field() }}

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" id="add_data" value="Add">
      </div>
      </form>
    </div>
  </div>
</div>
