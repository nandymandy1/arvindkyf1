@extends('layouts.app')


@section('content')
<div class="row">
  <div class="col-md-6">
      <h3 class="page-heading mb-4">Cuting</h3>
  </div>
  <div class="col-md-6">
    <button type="button" class="btn btn-md btn-primary pull-right" id="add" name="button" data-toggle="modal" data-target="#cuttingModal">Add Today's Data</button>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4">Line chart</h5>
        <canvas id="lineChart" style="height:250px"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4">Bar chart</h5>
        <canvas id="barChart" style="height:230px"></canvas>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4">Area chart</h5>
        <canvas id="areaChart" style="height:250px"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-4">Doughnut chart</h5>
        <canvas id="doughnutChart" style="height:250px"></canvas>
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
<script type="text/javascript">
  $(document).ready(() => {
    var shirtbox = $('#shirts');
    var knitbox = $('#knits');
    var womanbox = $('#women');
    var trouserbox = $('#trousers');
    var jeanbox = $('#jeans');

    var shirt = $('#shirt');
    var knit = $('#knit');
    var woman = $('#woman');
    var trouser = $('#trouser');
    var jean = $('#jean');

    shirt.hide();
    knit.hide();
    woman.hide();
    trouser.hide();
    jean.hide();

    shirtbox.change(() => {
      if(shirtbox.is(':checked')){
        shirt.show();
      }else{
        shirt.hide();
      }
    });

    knitbox.change(() => {
      if(knitbox.is(':checked')){
        knit.show();
      }else{
        knit.hide();
      }
    });

    womanbox.change(() => {
      if(womanbox.is(':checked')){
        woman.show();
      }else{
        woman.hide();
      }
    });

    trouserbox.change(() => {
      if(trouserbox.is(':checked')){
        trouser.show();
      }else{
        trouser.hide();
      }
    });

    jeanbox.change(() => {
      if(jeanbox.is(':checked')){
        jean.show();
      }else{
        jean.hide();
      }
    });

    // Form subimssion method goes Here
    $('#add').click(() => {
      $('#cutting_form')[0].reset();
      $('#form-output').html('');
      $('#add_data').val('Add');
    });

    $('#cutting_form').on('submit', (event) => {
      event.preventDefault();
      var form_data = $(this).serialize();

      $.ajax({
        url:"{{route('ajaxdata.postcutting')}}",
        method: "POST",
        data: form_data,
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
                $('#cutting_form')[0].reset();
                $('#add_data').val('Add');
                $('.modal_title').text('Add Today\'s Cutting Data');
                shirt.hide();
                knit.hide();
                woman.hide();
                trouser.hide();
                jean.hide();
              }
            }
      });
    });


});



</script>


@endsection



<!--Add Cutting Modal Goes Here-->
<!-- Modal -->
<div class="modal fade" id="cuttingModal" tabindex="-1" role="dialog" aria-labelledby="cuttingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Today's Cutting Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms" method="post" id="cutting_form">
          {{ csrf_field() }}
          <span id="form_output"></span>
          <input type="hidden" name="factory_id" value="{{Auth::user()->factory_id}}">
          <div class="form-group">
            <label for="cut_qty">Cut Quantity</label>
            <input type="text" class="form-control" name="cut_qty" id="cut_qty" value="" placeholder="Cut Quantity">
          </div>
          <div class="form-group">
            <label for="">Consumption</label>
            <div class="form-check">
            <label>
                <input type="checkbox" id="shirts" class="form-check-input" name="shirts" value="Shirt">
                Shirt
            </label>
            </div>
            <div class="form-check">
            <label>
                <input type="checkbox" id="women" class="form-check-input" name="women" value="Women Wear">Women Wear
            </label>
            </div>
            <div class="form-check">
            <label>
                <input type="checkbox" id="knits" class="form-check-input" name="knits" value="Knits">Knits
            </label>
            </div>
            <div class="form-check">
            <label>
                <input type="checkbox" id="trousers" class="form-check-input" name="trousers" value="Trouser">Trouser
            </label>
            </div>
            <div class="form-check">
            <label>
                <input type="checkbox" id="jeans" class="form-check-input" name="jeans" value="Jeans">Jeans
            </label>
            </div>
          </div>
          <div class="form-group" id="shirt">
            <label for="">Shirt</label>
            <input type="text" name="shirt" class="form-control" value="">
          </div>
          <div class="form-group" id="woman">
            <label for="">Women</label>
            <input type="text" name="woman" class="form-control" value="">
          </div>
          <div class="form-group" id="knit">
            <label for="">Knits</label>
            <input type="text" name="knit" class="form-control" value="">
          </div>
          <div class="form-group" id="jean">
            <label for="">Jeans</label>
            <input type="text" name="jean" class="form-control" value="">
          </div>
          <div class="form-group" id="trouser">
            <label for="">Trousers</label>
            <input type="text" name="trouser" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">People in Cutting Department</label>
            <input type="text" name="people" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Pieces sent for sewing or embroidary</label>
            <input type="text" name="pcs_sew_emb" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">No. of Cutting Men</label>
            <input type="text" name="c_men" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">No. of cutting machines used</label>
            <input type="text" name="mcs_used" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">No. of band knife</label>
            <input type="text" name="no_bandkife" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">No. of straight knife</label>
            <input type="text" name="no_stknife" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Number of fusing machines</label>
            <input type="text" name="no_fusing" class="form-control" value="">
          </div>
          <div class="form-group">
            <label for="">Fusing Output</label>
            <input type="text" name="fusing_out" class="form-control" value="">
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
