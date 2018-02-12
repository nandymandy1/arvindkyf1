@extends('layouts.app')



@section('content')


  <div class="card-deck">
    <div class="card col-lg-12 px-0 mb-4">
      <br>
      <div class="row">
        <div class="col-md-4">
          <a href="" class="btn btn-md btn-primary">Users Page</a>
        </div>
        <div class="col-md-4">
          <button type="button" name="button" class="btn btn-md btn-primary">Add</button>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">Factories</h5>
        <div class="table-responsive">
          <table class="table center-aligned-table table-bordered" id="factory_table">
            <thead>
              <tr class="text-primary">
                  <th>#</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Email</th>
                  <th>Action</th>
                  <!--<th>Message</th>
                  <th>Edit</th>
                  <th>Delete</th>-->
              </tr>
            </thead>
            </table>
          </div>
        </div>
      </div>
    </div>






@endsection


@section('scripts')

<script type="text/javascript">
  $(document).ready(()=>{
    $('#factory_table').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "{{route('getfactories')}}",
      "columns":[
        {"data": "id"},
        {"data": "name"},
        {"data": "contact"},
        {"data": "email"},
        {"data": "action", orderable:false, searchable: false}
      ]
    });
  });
</script>

@endsection
