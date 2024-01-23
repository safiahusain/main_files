@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Bulk Upload')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Bulk Upload')}}</h1>

          </div>

          <div class="section-body">
            <a href="{{ route('admin.state.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.State List')}}</a>

            <a href="{{ route('admin.state-export') }}" class="btn btn-success"><i class="fas fa-file-export"></i> {{__('admin.Export State List')}}</a>

            <a href="{{ route('admin.state-demo-export') }}" class="btn btn-primary"><i class="fas fa-file-export"></i> {{__('admin.Demo Export')}}</a>

            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.state-import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('File')}} <span class="text-danger">*</span></label>
                                    <input type="file" id="name" class="form-control-file"  name="import_file" required>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('Upload')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>

          <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>{{__('Country Id')}}</td>
                            <td>{{__('Required Field. Please make sure that you put in valid country id from country table')}}</td>
                        </tr>

                        <tr>
                            <td>{{__('Name')}}</td>
                            <td>{{__('Required Field')}}</td>
                        </tr>

                    </table>
                </div>
            </div>
          </div>

        </section>
      </div>

@endsection
