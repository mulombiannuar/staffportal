@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-desktop"></i>
                        {{ $log->name . ' - ' . $log->serial_number }}/{{ date_format(date_create($log->date_done), 'D, d M Y') }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>MAINTENANCE DETIALS</th>
                                <th>FACTS AND FINDINGS</th>
                                <th>RECOMMENDATIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <dt>Hardware logs check</dt>
                                    <ul>
                                        <li>Check for any hardware deformity(mouse, </li>
                                        <li>Blow out accumulated dust, spray the power supply </li>
                                        <li>Clean the monitor,keyboard, RAM and motherboard</li>
                                    </ul>
                                </td>
                                <td>{{ $log->hdw_log_status }}</td>
                                <td>{{ $log->hdw_log_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Hard disk clean up</dt>
                                    <ul>
                                        <li>Delete temporal files, recycle bin, cache </li>
                                    </ul>
                                </td>
                                <td>{{ $log->hdd_cleanup_status }}</td>
                                <td>{{ $log->hdd_cleanup_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Hard disk capacity check</dt>
                                    <ul>
                                        <li>Check for disk space in all the drives </li>
                                        <li>Uninstall and delete unused applications and icons</li>
                                    </ul>
                                </td>
                                <td>{{ $log->hdd_capacity_status }}</td>
                                <td>{{ $log->hdd_capacity_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Hardware tools</dt>
                                    <ul>
                                        <li>Run scandisk and defragment</li>
                                        <li>Check for disk errors</li>
                                    </ul>
                                </td>
                                <td>{{ $log->hdw_tools_status }}</td>
                                <td>{{ $log->hdw_tools_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Windows update</dt>
                                    <ul>
                                        <li>Download and install latest windows update</li>
                                    </ul>
                                </td>
                                <td>{{ $log->windows_update_status }}</td>
                                <td>{{ $log->windows_update_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Optimize browser</dt>
                                    <ul>
                                        <li>Delete cookies, caches and history file </li>
                                    </ul>
                                </td>
                                <td>{{ $log->browser_status }}</td>
                                <td>{{ $log->browser_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Software logs check</dt>
                                    <ul>
                                        <li>Check for applications windows problem(e.g. word, excel,
                                            outlook)</li>
                                    </ul>
                                </td>
                                <td>{{ $log->sftw_status }}</td>
                                <td>{{ $log->sftw_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Antivirus update check</dt>
                                    <ul>
                                        <li>Check that virus signatures have been updated</li>
                                    </ul>
                                </td>
                                <td>{{ $log->antivirus_status }}</td>
                                <td>{{ $log->antivirus_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Antivirus log check</dt>
                                    <ul>
                                        <li>Check for any virus on the network</li>
                                    </ul>
                                </td>
                                <td>{{ $log->antivirus_log }}</td>
                                <td>{{ $log->antivirus_log_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Security logs check</dt>
                                    <ul>
                                        <li>Check for any security threat on the machine</li>
                                    </ul>
                                </td>
                                <td>{{ $log->security_log }}</td>
                                <td>{{ $log->security_log_comment }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <dt>Files/folder backup</dt>
                                    <ul>
                                        <li>Create data backup</li>
                                        <li>Ensure that the official files and folders are well filed in
                                            the right procedure.</li>
                                    </ul>
                                </td>
                                <td>{{ $log->backup_status }}</td>
                                <td>{{ $log->backup_comment }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-users"></i>
                        ICT Overall Comment
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <form class="form-horizontal" method="post"
                                action="{{ route('admin.logs.comment', $log->log_id) }}">
                                <input type="hidden" name="type" value="officer">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="cost">ICT Officer Comment</label>
                                    <textarea class="form-control" rows="3" id="comment" name="comment"
                                        required="required"
                                        placeholder="Enter ICT Officer comments and recommendation here ...">{{ $log->supervisor_comment }}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info"> <i class="fa fa-plus"></i>
                                        Save Officer Comment</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <form class="form-horizontal" method="post"
                                action="{{ route('admin.logs.comment', $log->log_id) }}">
                                <input type="hidden" name="type" value="manager">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="cost">ICT Manager Comment</label>
                                    <textarea class="form-control" rows="3" id="comment" name="comment"
                                        required="required"
                                        placeholder="Enter ICT Manager comment here ......">{{ $log->manager_comment }}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-warning"> <i class="fa fa-plus"></i>
                                        Save Manager Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
