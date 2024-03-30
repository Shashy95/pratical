@extends('layouts.app')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Posts</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Posts
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Posts</a>
                            </li>
                            
                             
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                      <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 201.219px;">Title</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Created By</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 108.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($posts))
                                            @foreach ($posts as $row)
                            <tr class="gradeA even" role="row">
                                <th>{{ $loop->iteration }}</th>
                                <td>{{$row->title}}</td>
                                <td> {{$row->user->name}}</td>
                                                


                                        <td>
                                            <div class="form-inline">
                                            
                                       

                                            <a class="list-icons-item text-primary"
                                            href="{{ route("posts.show", $row->id)}}"><i
                                                class="fas fa-eye"></i>
                                        </a>&nbsp

                                         @if(auth()->user()->id == $row->user_id)
                                        <a class="list-icons-item text-primary"
                                                href="{{ route("posts.edit", $row->id)}}"><i
                                                    class="fas fa-pencil"></i>
                                            </a>
                              &nbsp
                            
    {!! Form::open(['route' => ['posts.destroy',$row->id], 'method' => 'delete']) !!}
            {{ Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
            {{ Form::close() }}
            @endif
                        
                        </div>
  
                                        </td>
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="">
                                    <br>
                                    <div class="card-header">
                                        
                                    @if(!empty($id))
                                            <h5>Edit Posts</h5>
                                            @else
                                            <h5>Add New Posts</h5>
                                            @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            @if(isset($id))
                                                    {{ Form::model($id, array('route' => array('posts.update', $id), 'method' => 'PUT')) }}
                                                    @else
                                                    {{ Form::open(['route' => 'posts.store']) }}
                                                    @method('POST')
                                                    @endif

                    <div class="form-group row"><label
                            class="col-lg-2 col-form-label">Title</label>

                        <div class="col-lg-10">
                            <input type="text" name="title"
                                value="{{ isset($data) ? $data->title : ''}}"
                                class="form-control" required>
                        </div>
                    </div>
       
                  

                <div class="form-group row"><label
                            class="col-lg-2 col-form-label">Body</label>

                        <div class="col-lg-10">
                <textarea name="body"  class="form-control">  {{ isset($data) ? $data->body : ''}} </textarea>
                                                                                    

</div>
                    </div>

                            
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


@endsection

@section('scripts')
<script>
$(document).ready( function () {
    $('.datatable-basic').DataTable();
} );

       
    </script>

@endsection