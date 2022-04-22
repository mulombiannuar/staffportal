@extends('layouts.admin.table')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="margin mb-2 text-right">
      <button type="button" data-toggle="modal" data-target="#modalAddMeeting" class="btn btn-primary"><i
          class="fa fa-plus"></i> Add New Group Meeting</button>
    </div>

    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title"><i class="fa fa-list"></i> {{ $title }} ({{ $meetings->count() }})</h3>
      </div>
      <div class="card-body">
        <table id="table1" class="table table-sm table-striped table-bordered table-head-fixed">
          <thead>
            <tr>
              <th>SN</th>
              <th>Group Name</th>
              <th>Group Code</th>
              <th>Branch</th>
              <th>Officer</th>
              <th>Day/Time</th>
              <th>Venue</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($meetings as $meeting)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $meeting->group_name }}</td>
              <td><strong>{{ $meeting->group_code }}</strong></td>
              <td>{{ $meeting->branch_name }}</td>
              <td>{{ $meeting->officer }}</td>
              <td>{{ $meeting->day.', '.$meeting->starting_time.' - '.$meeting->ending_time, }}</td>
              <td>{{ $meeting->place }}</td>
              <td>
                <div class="margin">
                  <div class="btn-group">
                    <button type="button" data-toggle="modal" data-target="#modalEditMeeting-{{ $meeting->meeting_id }}"
                      class="btn btn-xs btn-warning"><i class="fa fa-edit"></i>
                      Edit</button>
                  </div>
                  <div class="btn-group">
                    <form action="{{ route('user.meetings.destroy', $meeting->meeting_id) }}" method="post"
                      onclick="return confirm('Do you really want to delete this group meeting?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>
                        Delete</button>
                    </form>
                  </div>
                </div>
              </td>
              <!--/.modal begin -->
              <div class="modal fade" id="modalEditMeeting-{{ $meeting->meeting_id }}" style="display: none;"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Update Group Meeting</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{ route('user.meetings.update', $meeting->meeting_id) }}" method="post">
                      @csrf
                      @method('PUT')
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="group_code">Group</label>
                              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                              <input type="hidden" name="outpost_id" value="{{ Auth::user()->profile->outpost }}">
                              <input type="text" disabled class="form-control" name="group_name"
                                value="{{ $meeting->group_code .' - '.$meeting->group_name }}">
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="date">Frequency</label>
                              <select name="frequency" id="frequency" class="form-control select2" required>
                                <option class="mb-1" value="{{ $meeting->frequency }}">
                                  {{ $meeting->frequency }}</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Fortnightly">Fortnightly</option>
                                <option value="Monthly">Monthly</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="place">Meeting Place</label>
                              <input type="text" name="place" class="form-control" id="place"
                                value="{{ $meeting->place }}" placeholder="Enter meeting place" autocomplete="on"
                                required>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="day">Meeting Day</label>
                              <select name="day" id="day" class="form-control select2" required>
                                <option class="mb-1" value="{{ $meeting->day }}">
                                  {{ $meeting->day }}</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="starting_time">Starting Time</label>
                              <input type="time" name="starting_time" class="form-control" id="starting_time"
                                placeholder="Enter starting time" value="{{ $meeting->starting_time }}"
                                autocomplete="on" required>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="ending_time">Ending Time</label>
                              <input type="time" name="ending_time" class="form-control" id="ending_time"
                                placeholder="Enter ending time" value="{{ $meeting->ending_time }}" autocomplete="on"
                                required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label for="additional_info">Additional Information</label>
                              <textarea name="additional_info" id="additional_info" class="form-control" cols="2"
                                rows="3">{{ $meeting->additional_info }}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> Update Meeting
                          Data</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!--/modal end -->
            </tr>
            @endforeach
          </tbody>
        </table>

        <!--/.modal begin -->
        <div class="modal fade" id="modalAddMeeting" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add New Meeting</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form action="{{ route('user.meetings.store') }}" method="post">
                @csrf
                <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="group_code">Group</label>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="outpost_id" value="{{ Auth::user()->profile->outpost }}">
                        <select name="group_code" id="group_code" class="form-control select2" required>
                          <option class="mb-1" value="">
                            - Select Group Below -</option>
                          @foreach ($groups as $group)
                          <option value="{{ $group->GroupID .'%'.$group->GroupName.'%'.$group->Officer1 }}">{{
                            $group->GroupID .' - '.$group->GroupName }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="date">Frequency</label>
                        <select name="frequency" id="frequency" class="form-control select2" required>
                          <option class="mb-1" value="">
                            - Select Frequency -</option>
                          <option value="Weekly">Weekly</option>
                          <option value="Fortnightly">Fortnightly</option>
                          <option value="Monthly">Monthly</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="place">Meeting Place</label>
                        <input type="text" name="place" class="form-control" id="place" value="{{ old('place') }}"
                          placeholder="Enter meeting place" autocomplete="on" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="day">Meeting Day</label>
                        <select name="day" id="day" class="form-control select2" required>
                          <option class="mb-1" value="">
                            - Select Day -</option>
                          <option value="Monday">Monday</option>
                          <option value="Tuesday">Tuesday</option>
                          <option value="Wednesday">Wednesday</option>
                          <option value="Thursday">Thursday</option>
                          <option value="Friday">Friday</option>
                          <option value="Saturday">Saturday</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="starting_time">Starting Time</label>
                        <input type="time" name="starting_time" class="form-control" id="starting_time"
                          placeholder="Enter starting time" value="{{ old('starting_time') }}" autocomplete="on"
                          required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="ending_time">Ending Time</label>
                        <input type="time" name="ending_time" class="form-control" id="ending_time"
                          placeholder="Enter ending time" value="{{ old('ending_time') }}" autocomplete="on" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="additional_info">Additional Information</label>
                        <textarea name="additional_info" id="additional_info" class="form-control" cols="2"
                          rows="3">{{ old('additional_info') }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add New Meeting</button>
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!--/modal end -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection