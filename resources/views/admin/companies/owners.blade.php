@extends('admin.layouts.master')
@push('title')
    Companies
@endpush
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .grid .gird_item {
            border: 1px solid gray;
            padding: 10px;
        }

        .input-file {
            display: none; /* Hide the default file input */
            /* Add your custom styling here */
            /* Example styles */
            border: 1px solid #ccc;
            padding: 8px 12px;
            cursor: pointer;
            /* Customize further as needed */
        }

        .input-file-label {
            /* Style the visible label to look like a button */
            display: inline-block;
            padding: 8px 12px;
            background-color: #af4a43;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #af4a43;
        }
    </style>
@endpush
@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="font-weight-bold"> Owners/Members Of {{$company->company_name}} Company</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Ownership Percent</th>
                        <th>Address</th>
                    </tr>
                    @foreach($owners as $owner)

                        <tr>
                            <td><a href="{{route('admin.ownerInfo',$owner)}}" class="badge bg-info">Emails</a> </td>
                            <td>{{ $owner->name }}</td>
                            <td>{{ $owner->email }}</td>
                            <td>{{ $owner->phone }}</td>
                            <td>{{ $owner->ownership_percentage }}</td>
                            <td>{{ $owner->street_address }}, {{ $owner->city }}, {{ $owner->State }}- {{ $owner->zip_code }}, {{ $owner->Country }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection

{{--Registered Agent & Business Address--}}
{{--EIN--}}
{{--Operating Agreement / Corporate Bylaws--}}
{{--Expedited Filing--}}

@push('js')

@endpush
