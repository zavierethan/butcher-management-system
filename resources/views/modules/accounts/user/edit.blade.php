@extends('layouts.main')

@section('main-content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        User</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Accounts</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Users</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-body pt-10">
                            <form class="w-[60%]" method="post" action="{{route('users.update')}}">
                                @csrf
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Username</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="text" placeholder="" name="username" id="username" value="{{$user->name}}"/>
                                            <input type="hidden" name="id" id="new-id" value="{{$user->id}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Email</label>
                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-md form-control-solid" type="email" placeholder="" name="email" id="email" value="{{$user->email}}" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Group</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="group_id">
                                                <option value=""></option>
                                                @foreach($groups as $group)
                                                <option value="{{$group->id}}" <?php echo ($user->group_id == $group->id) ? "selected" : ""; ?>>{{$group->code}} - {{$group->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Branch</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="branch_id">
                                                <option value=""></option>
                                                @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" <?php echo ($user->branch_id == $branch->id) ? "selected" : ""; ?>>{{$branch->code}} - {{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="fv-row mb-5">
                                    <div class="mb-1">
                                        <label class="form-label fw-bold fs-6 mb-2">Is Active</label>
                                        <div class="position-relative mb-3">
                                            <select class="form-select form-select-solid" data-control="select2" data-placeholder="-" name="is_active">
                                                <option value=""></option>
                                                <option value="1" <?php echo ($user->is_active == 1) ? "selected" : ""; ?>>Yes</option>
                                                <option value="0" <?php echo ($user->is_active == 0) ? "selected" : ""; ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-5"></div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{route('users.index')}}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection
