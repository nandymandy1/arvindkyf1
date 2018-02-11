@extends('layouts.app')


@section('content')
<div class="row">
  <div class="col-md-6">
      <h3 class="page-heading mb-4">Charts</h3>
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
        <form class="" action="" method="post">
          {{ csrf_field() }}
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
