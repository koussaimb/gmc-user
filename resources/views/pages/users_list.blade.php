@extends('layouts.default')

@section('content')
    <div class="container">
        <table class="table table-condensed" style="border-collapse:collapse;">
            <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Date</th>
                <th>Tâches</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="tbody_data">

            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function () {
            $.ajax({
                type: 'GET',
                url: '/api/users',
                success: function (result) {
                    for (var i = 0; i < result.data.length; i++) {
                        $("#tbody_data").append(" <tr><td>" + [result.data[i].id] + "</td><td>" + [result.data[i].name] + "</td><td>" + [result.data[i].first_name] + "</td><td>" + [result.data[i].email] + "</td><td>" + [result.data[i].created_at] + "</td>" +
                        "<td data-toggle=\"collapse\" data-target=\"#demo1\" class=\"accordion-toggle\"><i class=\"far fa-caret-square-down\"></i></td><td><i style='color: green; cursor: pointer' class=\"fas fa-edit\"></i> <i style='color:red; cursor: pointer' class=\"far fa-trash-alt\" id='btn_delete_user' onclick='deleteUser("+result.data[i].id+")'></i></td></tr><tr><td colspan=\"6\" class=\"hiddenRow\"><div class=\"accordian-body collapse\" id=\"demo1\"> Demo1 </div> </td></tr>");
                    }
                },
                error: function (result) {
                }
            });



        });

        function  deleteUser(user_id) {
           if (user_id != null) {
               $.ajax({
                   type: 'DELETE',
                   url: '/api/users/'+user_id,
                   success: function (result) {

                   },
                   error: function (result) {
                   }
               });
           }
        }
    </script>
@stop

