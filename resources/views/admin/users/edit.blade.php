@extends('layouts.admin.master')


@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 mt-4">
          <div class="col-12">
            <h1 class="m-0 text-dark">
                <a class="nav-link drawer" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                کاربران / بروزرسانی {{ $user->name }}
                <a class="btn btn-primary float-left text-white py-2 px-4" href="{{ route('admin.users.index') }}">بازگشت به صفحه کاربران</a>
            </h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          @include('errors.message')
          <div class="row mt-5">
              <div class="col-md-12">
                  <div class="card card-defualt">
                      <!-- form start -->
                      <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>نام و نام خانوادگی</label>
                                          <input type="text" class="form-control" name="name" placeholder="نام و نام خانوادگی را وارد کنید" value="{{ $user->name }}">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>ایمیل</label>
                                          <input type="email" class="form-control" name="email" placeholder="ایمیل را وارد کنید" value="{{ $user->email }}">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>موبایل</label>
                                          <input type="text" class="form-control" name="mobile" placeholder="موبایل را وارد کنید" value="{{ $user->mobile }}">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>پسورد جدید</label>
                                          <input type="password" class="form-control" name="password" placeholder="پسورد جدید را وارد کنید" >
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>تایید پسورد جدید</label>
                                          <input type="password" class="form-control" name="password_confirmation" placeholder="پسورد جدید را دوباره وارد کنید">
                                      </div>
                                  </div>s
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>نقش کاربری</label>
                                          <select class="form-control" name="role">
                                              <option value="user" {{ $user->role == 'user' ? 'selected' : ''}}>کاربر عادی</option>
                                              {{-- <option value="2">طراح و فروشنده</option> --}}
                                              <option value="admin" {{ $user->role == 'admin' ? 'selected' : ''}}>مدیر</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>


                          </div>
                          <!-- /.card-body -->

                          <div class="card-footer">
                              <button type="submit" class="btn btn-primary float-left">ذخیره کردن</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
