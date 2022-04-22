@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-desktop"></i> Desktop Maintenance Log
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body container">
                    <form class="form-horizontal" method="post" action="{{ route('admin.logs.save') }}">
                        @csrf
                        <input type="hidden" name="current_user" value="{{ $asset->assigned_to }}">
                        <input type="hidden" name="product_id" value="{{ $asset->product_id }}">
                        <input type="hidden" name="asset_id" value="{{ $asset->desktop_id }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="date_done">Schedule Date</label>
                                    <input type="date" name="date_done" class="form-control" id="date_done"
                                        value="{{ date('Y-m-d') }}" placeholder="Select date done" autocomplete="on"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cost">Schedule Cost</label>
                                    <input type="number" name="cost" class="form-control" id="cost"
                                        value="{{ old('cost') }}" placeholder="Enter maintenance cost" autocomplete="on"
                                        required>
                                </div>
                            </div>
                        </div>
                        <Fieldset class="form-group">
                            <legend>Hardware Maintenance</legend>
                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Hardware logs check</dt>
                                    <ul>
                                        <li>Check for any hardware deformity(mouse, </li>
                                        <li>Blow out accumulated dust, spray the power supply </li>
                                        <li>Clean the monitor,keyboard, RAM and motherboard</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="hdw_log_status" name="hdw_log_status"
                                        required="required"
                                        placeholder="Describe the Hardware logs check findings/status of the device here.......">{{ old('hdw_log_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="hdw_log_comment" name="hdw_log_comment"
                                        required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('hdw_log_comment') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Hard disk clean up</dt>
                                    <ul>
                                        <li>Delete temporal files, recycle bin, cache </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="hdd_cleanup_status"
                                        name="hdd_cleanup_status" required="required"
                                        placeholder="Describe the Hard disk clean up findings/status of the device here.......">{{ old('hdd_cleanup_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="hdd_cleanup_comment"
                                        name="hdd_cleanup_comment" required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('hdd_cleanup_comment') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Hard disk capacity check</dt>
                                    <ul>
                                        <li>Check for disk space in all the drives </li>
                                        <li>Uninstall and delete unused applications and icons</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="hdd_capacity_status"
                                        name="hdd_capacity_status" required="required"
                                        placeholder="Describe the Hard disk capacity check findings/status of the device here.......">{{ old('hdd_capacity_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="hdd_capacity_comment"
                                        name="hdd_capacity_comment" required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('hdd_capacity_comment') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Hardware tools</dt>
                                    <ul>
                                        <li>Run scandisk and defragment</li>
                                        <li>Check for disk errors</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="hdw_tools_status" name="hdw_tools_status"
                                        required="required"
                                        placeholder="Describe the Hard disk capacity check findings/status of the device here.......">{{ old('hdw_tools_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="hdw_tools_comment"
                                        name="hdw_tools_comment" required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('hdw_tools_comment') }}</textarea>
                                </div>
                            </div>
                        </Fieldset>

                        <Fieldset class="form-group">
                            <legend>Software Maintenance</legend>
                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Windows update</dt>
                                    <ul>
                                        <li>Download and install latest windows update</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="windows_update_status"
                                        name="windows_update_status" required="required"
                                        placeholder="Describe the Windows update findings/status of the device here.......">{{ old('windows_update_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="windows_update_comment"
                                        name="windows_update_comment" required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('windows_update_status') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Optimize browser</dt>
                                    <ul>
                                        <li>Delete cookies, caches and history file </li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="browser_status" name="browser_status"
                                        required="required"
                                        placeholder="Describe browser findings/status of the device here.......">{{ old('browser_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="browser_comment" name="browser_comment"
                                        required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('browser_comment') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Software logs check</dt>
                                    <ul>
                                        <li>Check for applications windows problem(e.g. word, excel,
                                            outlook)</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="sftw_status" name="sftw_status"
                                        required="required"
                                        placeholder="Describe the Software logs check findings/status of the device here.......">{{ old('sftw_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="sftw_status" name="sftw_comment"
                                        required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('sftw_comment') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Antivirus update check</dt>
                                    <ul>
                                        <li>Check that virus signatures have been updated</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="antivirus_status" name="antivirus_status"
                                        required="required"
                                        placeholder="Describe the Hard disk capacity check findings/status of the device here.......">{{ old('antivirus_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="antivirus_status" name="antivirus_comment"
                                        required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('antivirus_comment') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Antivirus log check</dt>
                                    <ul>
                                        <li>Check for any virus on the network</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="antivirus_log" name="antivirus_log"
                                        required="required"
                                        placeholder="Describe the Antivirus log check findings/status of the device here.......">{{ old('antivirus_log') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="antivirus_log_comment"
                                        name="antivirus_log_comment" required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('antivirus_log_comment') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Security logs check</dt>
                                    <ul>
                                        <li>Check for any security threat on the machine</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="security_log" name="security_log"
                                        required="required"
                                        placeholder="Describe the Security logs check findings/status of the device here.......">{{ old('security_log') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="security_log_comment"
                                        name="security_log_comment" required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('security_log_comment') }}</textarea>
                                </div>
                            </div>
                        </Fieldset>

                        <Fieldset class="form-group">
                            <legend>Data Backup</legend>
                            <div class="form-group row ">
                                <div class="col-sm-4">
                                    <dt>Files/folder backup</dt>
                                    <ul>
                                        <li>Create data backup</li>
                                        <li>Ensure that the official files and folders are well filed in
                                            the right procedure.</li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="backup_status" name="backup_status"
                                        required="required"
                                        placeholder="Describe the Files/folder backup findings/status of the device here.......">{{ old('backup_status') }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    <textarea class="form-control" rows="3" id="backup_comment" name="backup_comment"
                                        required="required"
                                        placeholder="Describe comments and recommendations here ......">{{ old('backup_comment') }}</textarea>
                                </div>
                            </div>
                        </Fieldset>
                        <div class="card-footer justify-content-between">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-user-plus"></i>
                                Save Maintenance Log Data</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
