@extends('layouts.admin.table')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="margin mb-2 text-right">
                <a href="{{ route('customers.campaigns.create') }}">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Campaigm </button>
                </a>
            </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-list"></i> Manage Campaigns
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="table1" class="table table-sm table-bordered table-striped table-head-fixed">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>CAMPAIGN NAME</th>
                                <th>START DATE</th>
                                <th>END DATE</th>
                                <th>TARGET AREAS</th>
                                <th>TARGET PRODUCTS</th>
                                <th>CR RATE%</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campaigns as $campaign)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('customers.campaigns.show', $campaign->campaign_id) }}">
                                            {{ strtoupper($campaign->campaign_name) }} ({{ $campaign->count }})
                                        </a>
                                    </td>
                                    <td>{{ $campaign->start_date }}</td>
                                    <td>{{ $campaign->end_date }}</td>
                                    <td>{{ $campaign->target_areas }}</td>
                                    <td>{{ $campaign->target_products }}</td>
                                    <td>{{ $campaign->user_name }}</td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <a href="{{ route('customers.campaigns.show', $campaign->campaign_id) }}">
                                                    <button type="button" class="btn btn-sm btn-info"><i
                                                            class="fa fa-eye"></i>
                                                        Show</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="{{ route('customers.campaigns.edit', $campaign->campaign_id) }}">
                                                    <button type="button" class="btn btn-sm btn-default"><i
                                                            class="fa fa-edit"></i>
                                                        Edit</button>
                                                </a>
                                            </div>
                                            <div class="btn-group">
                                                <form
                                                    action="{{ route('customers.campaigns.destroy', $campaign->campaign_id) }}"
                                                    method="post"
                                                    onclick="return confirm('Do you really want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                                            class="fa fa-trash"></i>
                                                        Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
