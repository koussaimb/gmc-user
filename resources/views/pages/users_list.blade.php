@extends('layouts.default')

@section('content')
    <div class="container">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalAddUser" style="float: right">+ Ajouter un utilisateur </button><br><br>
        
        <table class="table table-bordered table-hover" style="border-collapse:collapse;">
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
                        //get data from result to display inside table and create modal
                        $("#tbody_data").append(" <tr id="+"tr"+[result.data[i].id]+" ><td>" + [result.data[i].id] + "</td><td>" + [result.data[i].name] + "</td><td>" + [result.data[i].first_name] + "</td><td>" + [result.data[i].email] + "</td><td>" + [result.data[i].created_at] + "</td>" +
                            "<td data-toggle=\"collapse\" data-target="+"#"+[result.data[i].id]+" class=\"accordion-toggle\" onclick='getTaskByUser("+result.data[i].id+")'><i class=\"far fa-caret-square-down\"></i></td>" +
                            "<td><i style='color: blue; cursor: pointer'  data-toggle=\"modal\" data-target="+"#md"+[result.data[i].id]+"  class=\"fas fa-edit\"></i> " +
                            "<i style='color:red; cursor: pointer' class=\"far fa-trash-alt\" id='btn_delete_user' onclick='deleteUser("+result.data[i].id+")'></i></td>" +
                            "</tr><tr><td colspan=\"6\"  id="+"col"+[result.data[i].id]+" class=\"hiddenRow\"><div class=\"accordian-body collapse\" id="+[result.data[i].id]+"> <div id="+"tasks_"+[result.data[i].id]+"></div> </div> </td></tr>");

                        //create a dynamic var name for input for disable confilt with same names
                        var edit_name_input = "edit_name_"+result.data[i].id;
                        var edit_first_name_input = "edit_first_name_"+result.data[i].id;
                        var edit_email_input = "edit_email_"+result.data[i].id;

                        $("#display_modal_edit_user").append("<div class=\"modal fade\" id="+"md"+ [result.data[i].id] +" role=\"dialog\">\n" +
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
                            "                            <button type=\"button\" onclick='editUser("+result.data[i].id+")' class=\"btn btn-success\" >Enregistrer</button>\n" +
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
                          var  check_error = 'error' in result;
                          if (check_error){
                              alert(result.error[0]);
                          }else{
                              $("#tbody_data").append(" <tr id="+"tr"+[result.data.id]+" ><td>" + [result.data.id] + "</td><td>" + [result.data.name] + "</td><td>" + [result.data.first_name] + "</td><td>" + [result.data.email] + "</td><td>" + [result.data.created_at] + "</td>" +
                                  "<td data-toggle=\"collapse\" data-target="+"#"+[result.data.id]+" class=\"accordion-toggle\" onclick='getTaskByUser("+result.data.id+")'><i class=\"far fa-caret-square-down\"></i></td>" +
                                  "<td><i style='color: blue; cursor: pointer'  data-toggle=\"modal\" data-target="+"#md"+[result.data.id]+"  class=\"fas fa-edit\"></i> " +
                                  "<i style='color:red; cursor: pointer' class=\"far fa-trash-alt\" id='btn_delete_user' onclick='deleteUser("+result.data.id+")'></i></td>" +
                                  "</tr><tr><td colspan=\"6\"  id="+"col"+[result.data.id]+" class=\"hiddenRow\"><div class=\"accordian-body collapse\" id="+[result.data.id]+"> <div id="+"tasks_"+[result.data.id]+"></div> </div> </td></tr>");

                              //create a dynamic var name for input for disable confilt with same names
                              var edit_name_input = "edit_name_"+result.data.id;
                              var edit_first_name_input = "edit_first_name_"+result.data.id;
                              var edit_email_input = "edit_email_"+result.data.id;

                              $("#display_modal_edit_user").append("<div class=\"modal fade\" id="+"md"+ [result.data.id] +" role=\"dialog\">\n" +
                                  "                <div class=\"modal-dialog\">\n" +
                                  "                    <!-- Modal content-->\n" +
                                  "                    <div class=\"modal-content\">\n" +
                                  "                        <div class=\"modal-header\">\n" +
                                  "                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\n" +
                                  "                            <h4 class=\"modal-title\">Utilisateur N° " + [result.data.id] + " </h4> </div>\n" +
                                  "                        <div class=\"modal-body\">\n" +
                                  "                         <label for="+ [edit_name_input]+">Nom :</label>   <input class=\"form-control\" type='text' name="+ [edit_name_input]+" id="+ [edit_name_input]+" value=" + [result.data.name] +" ><br> \n" +
                                  "                         <label  for="+ [edit_first_name_input]+">Prénom :</label>    <input class=\"form-control\" type='text' name="+ [edit_first_name_input]+" id="+ [edit_first_name_input]+" value=" + [result.data.first_name] +" > <br>\n" +
                                  "                         <label for="+ [edit_email_input]+">Email :</label>     <input class=\"form-control\" type='email'name="+ [edit_email_input]+" id="+ [edit_email_input]+" value=" + [result.data.email] +" > \n" +
                                  "                        </div>\n" +
                                  "                        <div class=\"modal-footer\">\n" +
                                  "                            <button type=\"button\" onclick='editUser("+result.data.id+")' class=\"btn btn-success\" >Enregistrer</button>\n" +
                                  "                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>\n" +
                                  "                        </div></div>\n" +
                                  "                 </div> </div>");
                              $('#myModalAddUser').modal('toggle');
                          }
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
                                var  check_error = 'error' in result;
                                if (check_error){
                                    alert(result.error[0]);
                                }else{
                                    getTaskByUser(user_id);
                                    $("#myModalAddTask").modal('toggle');
                                    $("#add_task_name").val('');
                                    $("#add_description").val('');
                                    $('input[name="task_statut"]:checked').val('');
                                    $("#user_id_for_task").val('');
                                }
                            },
                            error: function (result) {
                            }
                        });
                    }
                }else{
                    alert("errure");
                }
            });
        });



        function  deleteUser(user_id) {
            if (user_id != null) {
                var result = confirm("vous êtes sur pour la supperession ?");
                if (result){
                    $.ajax({
                        type: 'DELETE',
                        url: '/api/users/'+user_id,
                        success: function (result) {
                            $("#"+user_id).hide();
                            $("#tr"+result.data.id).css("display", "none");
                            $("#col"+result.data.id).css("display", "none");
                        },
                        error: function (result) {
                        }
                    });
                }else{
                    $("#display_modal_edit_user").hide();
                }
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
                            var  check_error = 'error' in result;
                            if (check_error){
                                alert(result.error[0]);
                            }else{
                                $("#tr"+result.data.id).find("td:eq(1)").html(result.data.name);
                                $("#tr"+result.data.id).find("td:eq(2)").html(result.data.first_name);
                                $("#tr"+result.data.id).find("td:eq(3)").html(result.data.email);
                                $("#md"+result.data.id).modal('toggle');

                            }
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
                            $("#tasks_"+user_id).empty();
                            for (var i = 0; i < result.data.length; i++){
                                //check if status == 1 is done so add class with line-through for text
                                var style_status_task = "";
                                style_status_task = result.data[i].status === 1 ? 'task_done' : 'task_not_done';

                                $("#tasks_"+user_id).append("<ul class=\"list-group\"> <li class=\"list-group-item list-group-item-warning\" id="+"item_task_"+ + [result.data[i].id] + "><a   class=" + [style_status_task] + ">" + [result.data[i].name] + " |<i>Description : " + [result.data[i].description] + "</i></a>" +
                                    "<span onclick='deleteTask(" + [result.data[i].id] + ")'  style='color: red; cursor: pointer;'  class=\"fa-li\"><i class=\"fas fa-minus-circle\"></i></span></li>" +
                                    "<li onclick='toListRoute(" + [result.data[i].id] + ")'  id="+"item_task_updated_"+ + [result.data[i].id] + " class=\"list-group-item list-group-item-success\" style='cursor: pointer;' >Modifier </li></ul> <input type='hidden' id='getid' value=" + [result.data[i].id] + "> ");
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

        function toListRoute(task_id) {
            if (task_id){
                window.open('http://localhost:8000/task_detail/'+task_id, '_blank');
            }
        }

    </script>
@stop

