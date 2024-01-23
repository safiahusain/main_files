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
            <a href="{{ route('admin.shipping.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Shipping Rule')}}</a>

            <a href="{{ route('admin.shipping-export') }}" class="btn btn-success"><i class="fas fa-file-export"></i> {{__('admin.Export Shipping Rule')}}</a>

            <a href="{{ route('admin.shipping-demo-export') }}" class="btn btn-primary"><i class="fas fa-file-export"></i> {{__('admin.Demo Export')}}</a>

            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.shipping-import') }}" method="POST" enctype="multipart/form-data">
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
                            <td>City Id</td>
                            <td>Required Field. Please make sure that you put in valid city id from city/ delivery area table. Only numeric value allowed.</td>
                        </tr>

                        <tr>
                            <td>Shipping rule</td>
                            <td>Required Field</td>
                        </tr>

                        <tr>
                            <td>Type</td>
                            <td>Required Field. In this system 3 type of rules available. 'base_on_price' , 'base_on_weight' , 'base_on_qty' .</td>
                        </tr>

                        <tr>
                            <td>Condition From</td>
                            <td>Required Field. Only numeric value allowed.</td>
                        </tr>

                        <tr>
                            <td>Condition To</td>
                            <td>Required Field. For unlimited condition you can put (-1). Only numeric value allowed.</td>
                        </tr>

                        <tr>
                            <td>Shipping Fee</td>
                            <td>Required Field. Only numeric value allowed.</td>
                        </tr>

                    </table>
                </div>
            </div>
          </div>

        </section>
      </div>

@endsection
