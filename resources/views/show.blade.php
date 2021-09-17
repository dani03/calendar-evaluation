<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
         <!-- Styles -->
         <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        
         <!-- Scripts -->
         <script src="{{ asset('js/app.js') }}" defer></script>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
{{-- javascript --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>    

    </head>
    <body class="antialiased">
        <div class="relative flex justify-center mt-5">
            prendre rendez-vous
        </div>
        <div class="w-auto flex h-auto">
            <div class="border border-gray-200 w-1/5 text-center p-8 m-16 ">
                @foreach ($commercials as $commercial)
                    <a href="{{route('meeting.show', $commercial->id)}}" class="mb-5 "> {{$commercial->name}}</a><br>
                @endforeach
                
            </div>

            <div id='fullCalendar' class=" w-3/5 shadow-none"></div> 

        </div>
            <script>
                $(document).ready(function () {
        
                    var endpoint = "{{ url('/') }}";
        
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
        
                    var calendar = $('#fullCalendar').fullCalendar({
                        editable: true,
                        editable: true,
                        selectConstraint: {
                            start: $.fullCalendar.moment().subtract(1, 'days'),
                            end: $.fullCalendar.moment().startOf('month').add(1, 'month')
                        },
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                    events: [
                            {
                                title: 'Lunch',
                                    start: new Date("19-09-2021"),
                                    end: new Date("19-09-2021"),
                                    allDay: false
                                    
                            }
                        ],
                        displayEventTime: true,
                        eventRender: function (event, element, view) {
                            



                            if (event.allDay === 'true') {
                                event.allDay = false;
                            } else {
                                event.allDay = false;
                            }
                        },
                        selectable: true,
                        initialView: 'dayGridMonth',
              
                        selectHelper: true,
                        select: function (event_start, event_end, allDay) {
                            var event_title = prompt('entrez votre nom:');
                            
                            if (event_title) {
                                var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm");
                                var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm");
                                console.log(event_start, event_end, event_title);
                                $.ajax({
                                    url:  "/manage",
                                    data: {
                                        event_title: event_title,
                                        event_start: event_start,
                                        event_end: event_end,
                                        type: 'create'
                                    },
                                    type: "POST",
                                    success: function (data) {
                                       
                                        displayMessage("Event created.");
        
                                        calendar.fullCalendar('renderEvent', {
                                            id: data.id,
                                            title: event_title,
                                            start: event_start,
                                            end: event_end,
                                            allDay: allDay
                                        }, true);
                                        calendar.fullCalendar('unselect');
                                    }
                                });
                            }
                        },
                        eventDrop: function (event, delta) {
                            var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                            var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
        
                            $.ajax({
                                url:'/manage',
                                data: {
                                    title: event.event_title,
                                    start: event_start,
                                    end: event_end,
                                    id: event.id,
                                    type: 'edit'
                                },
                                type: "POST",
                                success: function (response) {
                                    displayMessage("Event updated");
                                }
                            });
                        },
                        
                    });
                });
        
                function displayMessage(message) {
                    toastr.success(message, 'Event');            
                }
            </script>
    </body>
</html>
