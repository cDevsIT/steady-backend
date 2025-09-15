@extends('web.layouts.master')
@push('title')
@endpush
@push('css')
    <style>
        body {
            overflow-x: hidden;
        }

        .panel {
            position: relative;
        }

        .left-sidebar {
            height: 100vh;
            background: #fff;
            border-right: 1px solid gray;
            padding: 15px;
            position: fixed;
            top: 18%;
            left: 0;
            width: 250px;
            z-index: 998;
            transform: translateX(-250px);
            transition: transform 0.3s ease;
        }

        .left-sidebar .nav-link {
            font-size: 16px;
            margin: 10px 0;
        }

        .left-sidebar .nav-link.active {
            background: #e9ecef;
            border-radius: 4px;
        }

        .left-sidebar.active {
            transform: translateX(0px);
            /*width: 0px;*/
        }

        .content {
            padding: 15px;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .toggle-btn {
            display: block;
            position: fixed;
            top: 19%;
            left: 0px;
            z-index: 999;
        }

        @media (max-width: 768px) {
            .left-sidebar {
                height: 100%;
            }

            .left-sidebar.active {
                transform: translateX(0);
            }

            .toggle-btn {
                display: block;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }

            .o_item_indicator {
                gap: 10px;
                overflow-x: scroll;
                text-wrap: nowrap;
            }

            .orderLine {
                overflow-x: scroll;
                text-wrap: nowrap;
            }

            .o_item:not(:last-child)::after {
                top: 16%;
                right: -59px;
                width: 100%;

            }

            .o_item:first-child::after {
                width: 78%;
            }
        }

        select#company {
            width: 100%;
            border: navajowhite;
            margin-top: 18px;
        }

        p.s_circle {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #FF5700;
            color: #FFFFFF;
            position: absolute;
            left: 43%;
            right: 50%;
            transform: translate(0px, -50%);
        }

        p.s_circle i {
            display: none;
        }

        p.s_circle.active {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #FF5700;
            color: #FFFFFF;
        }

        p.s_circle.active i {
            display: block;
        }

        /* Timeline line */
        .line {
            height: 2px;
            background-color: #FF5700;
            margin: 0 10px;
        }

        .o_item {
            position: relative;
            padding: 27px;
            flex: 1;
            text-align: center;
        }

        .o_item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 16%;
            right: -126px;
            width: 100%;
            height: 2px;
            background-color: #ff570054;
            transform: translateY(-50%);
            z-index: -1;
        }

        .o_item.active:not(:last-child)::after {
            background-color: #FF5700;
        }

        .s_tag {
            height: 50px;
            color: #000000;
            font-size: 16px;
            margin-top: 30px;
        }

        p.datetime {
            line-height: 0;
            margin-bottom: 39px;
        }

        .s_status {
            margin-top: 20px;
            color: #008220;
            background: #E7FFED;
            text-align: center;
        }

        .item_title {
            font-size: 18px;
            font-weight: 600;
        }

        /*DOCKS*/
        .doc_items {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            align-items: center;
        }

        .doc_item {
            background: #ff57000a;
            border-radius: 20px;
            padding: 0px 7px;
        }


        .company-details {
            background-color: #e0f7fa;
            padding: 20px;
            border-radius: 8px;

        }

        .company-details h2 {
            margin-top: 0;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 20px;
        }

        .detail-item {
            display: flex;
            justify-content: left;
            gap: 10px;
        }

        .detail-item strong {
            margin-right: 15px;
        }


        .member-details {
            background-color: #F0FFF0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 10px;
        }


        .member-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px 20px;
        }

        .member-item {
            display: flex;
            justify-content: left;
            gap: 10px;
        }

        .member-item strong {
            margin-right: 15px;
        }

        /*.d-flex::before {*/
        /*    content: '';*/
        /*    position: absolute;*/
        /*    top: 50%;*/
        /*    left: 0;*/
        /*    width: 100%;*/
        /*    height: 2px;*/
        /*    background-color: #000;*/
        /*    z-index: -1;*/
        /*    transform: translateY(-50%);*/
        /*}*/


        @media (max-width: 1200px) {
            .doc_items {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .doc_items {
                grid-template-columns: repeat(2, 1fr);
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .detail-item {
                justify-content: space-between;
            }

            .member-grid {
                grid-template-columns: 1fr;
            }

            .member-item {
                justify-content: space-between;
            }

        }

        @media (max-width: 600px) {
            .doc_items {
                grid-template-columns: 1fr;
            }
        }


    </style>





@endpush
@section('content')

    <div class="panel" id="panel">
        <button class="toggle-btn btn btn-light" id="toggleSidebar">☰</button>
        @include('web.dashboard.part.sidebar')

        <div id="content" class=" content">
            <div class="card" style="padding: 10px">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Tickets</h3>
                        <a href="{{route('web.makeTicket',session('active_company_id'))}}" class="btn btn-success"> <i class="fas fa-plus"></i> Make A Ticket</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover">
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Title</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Customer Phone</th>
                                <th>Action</th>
                            </tr>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td> @if($ticket->status == 'Open')
                                            <span class="badge bg-success">Open</span>
                                        @else
                                            <span class="badge bg-danger">Closed</span>
                                        @endif</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->first_name ." ". $ticket->last_name }}</td>
                                    <td>{{ $ticket->email }}</td>
                                    <td>{{ $ticket->phone }}</td>
                                    <td>
                                        <a href="{{route('web.viewTicket', $ticket->id)}}" class="btn btn-info"><i class="fas fa-eye"></i>View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>

        const content = document.getElementById('content');
        document.addEventListener("DOMContentLoaded", function () {
            let leftSidebar = document.querySelector("#left-sidebar")
            if (leftSidebar.classList.contains('active')) {
                content.style.marginLeft = "250px";
                // localStorage.setItem("isActive", true)
            } else {
                // localStorage.setItem("isActive", false)
                content.style.marginLeft = "0px";
            }
        })
        document.getElementById('toggleSidebar').addEventListener('click', function (e) {
            let leftSidebar = document.querySelector("#left-sidebar")
            e.stopPropagation(); // Prevents the sidebar from closing when clicking the toggle button
            document.getElementById('left-sidebar').classList.toggle('active');
            if (leftSidebar.classList.contains('active')) {
                content.style.marginLeft = "250px";
                // localStorage.setItem("isActive", true)
                console.log("yes")
            } else {
                content.style.marginLeft = "0px";

                localStorage.setItem("isActive", false)
                console.log("No")
            }
        });

        // document.addEventListener('click', function (e) {
        //     var sidebar = document.getElementById('left-sidebar');
        //     var toggleBtn = document.getElementById('toggleSidebar');
        //     if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
        //         sidebar.classList.remove('active');
        //     }
        //
        //     if (sidebar.classList.contains('active')) {
        //         content.style.marginLeft = "250px";
        //     } else {
        //         content.style.marginLeft = "0px";
        //     }
        // });

        window.addEventListener('scroll', function () {
            var sticky = 50;
            const leftSidebar = document.querySelector("#left-sidebar")
            const toggleButton = document.querySelector(".toggle-btn")
            if (window.pageYOffset >= sticky) {
                if (leftSidebar) {
                    leftSidebar.style.top = "14%";
                } else {
                    leftSidebar.style.top = "18%";
                }

                if (toggleButton) {
                    toggleButton.style.top = "15%";
                } else {
                    toggleButton.style.top = "19%";
                }
            } else {
                leftSidebar.style.top = "18%";
                toggleButton.style.top = "19%";
            }
        });
        const company = document.querySelector('#company')
        company.addEventListener('change', function () {
            window.location.href = this.options[this.selectedIndex].dataset.route;
        });

    </script>
@endpush
