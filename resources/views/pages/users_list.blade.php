@extends('layouts.default')

@section('content')
    <div class="container">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalAddUser" style="float: right">+ Ajouter </button>

        <table class="table table-condensed" style="border-collapse:collapse;">
            <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Date de création</th>
                <th>Tâches</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="tbody_data">

            </tbody>
        </table>
        <!-- modal for edit user !-->
        <div id="display_modal_edit_user">

        </div>

        <!-- modal for add user !-->
        <div id="display_modal_add_user">
            <div class="modal fade" id="myModalAddUser" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Ajouter un utilisateur</h4>
                        </div>
                        <div class="modal-body">
                            <p id="message_error" style="display: none; color: red">tous les champs sont obligatoires !</p>
                            <label for="add_name">Nom * : </label> <input required class="form-control" type="text" name="add_name" id="add_name" value="">
                            <label for="add_first_name">Prénom * : </label> <input required  class="form-control" type="text" name="add_first_name" id="add_first_name" value="">
                            <label for="add_email">Email * : </label> <input required  class="form-control" type="email" name="add_email" id="add_email" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn_add_user" name="btn_add_user"  class="btn btn-success">Ajouter</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- modal for add task !-->
        <div id="display_modal_add_task">
            <div class="modal fade" id="myModalAddTask" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <input type="hidden" id="user_id_for_task" name="user_id_for_task"  >
                            <h4 class="modal-title">Ajouter une tâche</h4>
                        </div>
                        <div class="modal-body">
                            <p id="message_error_add_task" style="display: none; color: red">Merci de respecter les obligatoires !</p>
                            <label for="add_task_name">Nom * : </label> <input required class="form-control" type="text" name="add_task_name" id="add_task_name" value="">
                            <label for="add_description">Description  : </label> <textarea   class="form-control"  name="add_description" id="add_description" value="" > </textarea><br>
                            <div class="form-control"><label> Statut * :</label>
                            <label for="add_statut_done"> Terminée </label><input  type="radio" id="add_statut_done" name="task_statut" value=1 >
                                <label for="add_statut_not_done"> Pas encore </label><input type="radio" id="add_statut_not_done" name="task_statut" value=0 checked>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn_add_task" name="btn_add_task"  class="btn btn-success">Ajouter</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // ajax request get users using api route
            //when success return a not empty data result will append in tbody
            $.ajax({
                type: 'GET',
                url: '/api/users',
                success: function (result) {
                    for (var i = 0; i < result.data.length; i++) {
                        $("#tbody_data").append(" <tr><td>" + [result.data[i].id] + "</td><td>" + [result.data[i].name] + "</td><td>" + [result.data[i].first_name] + "</td><td>" + [result.data[i].email] + "</td><td>" + [result.data[i].created_at] + "</td>" +
                            "<td data-toggle=\"collapse\" data-target="+"#"+[result.data[i].id]+" class=\"accordion-toggle\" onclick='getTaskByUser("+result.data[i].id+")'><i class=\"far fa-caret-square-down\"></i></td>" +
                            "<td><i style='color: blue; cursor: pointer'  data-toggle=\"modal\" data-target="+"#"+[result.data[i].id]+"  class=\"fas fa-edit\"></i> " +
                            "<i style='color:red; cursor: pointer' class=\"far fa-trash-alt\" id='btn_delete_user' onclick='deleteUser("+result.data[i].id+")'></i></td>" +
                            "</tr><tr><td colspan=\"6\" class=\"hiddenRow\"><div class=\"accordian-body collapse\" id="+[result.data[i].id]+"> <div id="+"tasks_"+[result.data[i].id]+"></div> </div> </td></tr>");

                        //create a dynamic var name for input for disable confilt with same names
                        var edit_name_input = "edit_name_"+result.data[i].id;
                        var edit_first_name_input = "edit_first_name_"+result.data[i].id;
                        var edit_email_input = "edit_email_"+result.data[i].id;

                        $("#display_modal_edit_user").append("<div class=\"modal fade\" id="+ [result.data[i].id] +" role=\"dialog\">\n" +
                            "                <div class=\"modal-dialog\">\n" +
                            "                    <!-- Modal content-->\n" +
                            "                    <div class=\"modal-content\">\n" +
                            "                        <div class=\"modal-header\">\n" +
                            "                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\n" +
                            "                            <h4 class=\"modal-title\">Utilisateur N° " + [result.data[i].id] + " </h4> </div>\n" +
                            "                        <div class=\"modal-body\">\n" +
                            "                         <label for="+ [edit_name_input]+">Nom :</label>   <input class=\"form-control\" type='text' name="+ [edit_name_input]+" id="+ [edit_name_input]+" value=" + [result.data[i].name] +" ><br> \n" +
                            "                         <label  for="+ [edit_first_name_input]+">Prénom :</label>    <input class=\"form-control\" type='text' name="+ [edit_first_name_input]+" id="+ [edit_first_name_input]+" value=" + [result.data[i].first_name] +" > <br>\n" +
                            "                         <label for="+ [edit_email_input]+">Email :</label>     <input class=\"form-control\" type='email'name="+ [edit_email_input]+" id="+ [edit_email_input]+" value=" + [result.data[i].email] +" > \n" +
                            "                        </div>\n" +
                            "                        <div class=\"modal-footer\">\n" +
                            "                            <button type=\"button\" onclick='editUser("+result.data[i].id+")' class=\"btn btn-success\" data-dismiss=\"modal\">Enregistrer</button>\n" +
                            "                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n" +
                            "                        </div></div>\n" +
                            "                 </div> </div>");

                    }
                },
                error: function (result) {
                }
            });

            $("#btn_add_user").on("click", function () {
                var add_name = $("#add_name").val();
                var add_first_name = $("#add_first_name").val();
                var add_email = $("#add_email").val();

                if (!add_name || !add_first_name || !add_email ){
                    $("#message_error").show();
                }else{
                    $("#message_error").hide();
                    $.ajax({
                        type: 'POST',
                        url: '/api/users/',
                        data:{
                            name        : add_name,
                            first_name  : add_first_name,
                            email       : add_email,
                        },
                        success: function (result) {
                            window.location.reload(true);
                        },
                        error: function (result) {
                        }
                    });
                }
            });


            $("#btn_add_task").on("click", function () {

                var add_task_name = $("#add_task_name").val();
                var add_description = $("#add_description").val();
                var task_statut = $('input[name="task_statut"]:checked').val();
                var user_id = $("#user_id_for_task").val();

                if (user_id != null){

                    if (!add_task_name && ! task_statut){
                        $("#message_error_add_task").show();
                    }else {
                        $("#message_error_add_task").hide();
                        $.ajax({
                            type: 'POST',
                            url: '/api/tasks/',
                            data: {
                                user_id :user_id,
                                name: add_task_name,
                                description: add_description,
                                status: task_statut,
                            },
                            success: function (result) {
                                window.location.reload(true);
                            },
                            error: function (result) {
                            }
                        });
                    }
                }else{
                    alert("errue");
                }
            });
        });



        function  deleteUser(user_id) {
            if (user_id != null) {
                $.ajax({
                    type: 'DELETE',
                    url: '/api/users/'+user_id,
                    success: function (result) {
                        window.location.reload(true);
                    },
                    error: function (result) {
                    }
                });
            }
        }

        function editUser(user_id) {
            //get input  by user_id concatenate with prefix name  like this edit_name_user_id
            if (user_id != null){
                var edit_name = $("#edit_name_"+user_id).val();
                var edit_first_name = $("#edit_first_name_"+user_id).val();
                var edit_email = $("#edit_email_"+user_id).val();


                if (!edit_name || !edit_first_name || !edit_email){
                    alert('tous les champs sont obligatoires !');
                }else{
                    $.ajax({
                        type: 'PUT',
                        url: '/api/users/'+user_id,
                        data:{
                            name        : edit_name,
                            first_name  : edit_first_name,
                            email       : edit_email,
                        },
                        success: function (result) {
                            window.location.reload(true);
                        },
                        error: function (result) {
                        }
                    });
                }

            }
        }

        function getTaskByUser(user_id) {
            if (user_id != null) {
                $.ajax({
                    type: 'GET',
                    url: '/api/tasksByUser/'+user_id,
                    success: function (result) {
                        if (result){
                            for (var i = 0; i < result.data.length; i++){
                                $("#tasks_"+user_id).append("<ul class=\"list-group\"> <li class=\"list-group-item list-group-item-warning\" id="+"item_task_"+ + [result.data[i].id] + "><a style='cursor: pointer'>" + [result.data[i].name] + " |<i>Description : " + [result.data[i].description] + "</i></a>" +
                                    "<span onclick='deleteTask(" + [result.data[i].id] + ")'  style='color: red; cursor: pointer;'  class=\"fa-li\"><i class=\"fas fa-minus-circle\"></i></span></li>" +
                                    "<li  id="+"item_task_updated_"+ + [result.data[i].id] + " class=\"list-group-item list-group-item-success\">Modifier </li></ul>");
                            }
                            $("#tasks_"+user_id).append("<ul class=\"list-group\"> <li class=\"list-group-item list-group-item-dark\" ><a id='opendModalAddTask'  data-toggle='modal'  data-target='#myModalAddTask' onclick='sendUserId(" + [user_id] + ")' style='cursor: pointer'>Ajouter une tâche</a> </ul>");
                        }
                    },
                    error: function (result) {

                    }

                });
            }
        }


        function deleteTask(task_id) {
           if (task_id != null){
               $.ajax({
                   type: 'DELETE',
                   url: '/api/tasks/'+task_id,
                   success: function (result) {
                       //as we i dont use a framework like reactjs for refresh i delete and hide the item deleted
                        $("#item_task_"+task_id).hide();
                        $("#item_task_updated_"+task_id).hide();
                   },
                   error: function (result) {
                   }
               });
           }
        }

        function sendUserId(user_id) {
            $("#user_id_for_task").val(user_id);
        }

    </script>
@stop

