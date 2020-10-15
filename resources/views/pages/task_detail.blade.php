@extends('layouts.default')

@section('content')
    @php
      if(isset($_GET['task']) && !is_null($_GET['task']))
        $task = $_GET['task'];
        $user = \App\User::find($task->user_id);
    @endphp
    <div class="container">
        <strong style="color: blue">Modification la tâche N° {{$task->id}} pour l'utilisateur {{$user->name}}</strong><br><br>
        <div class="col-lg-8">
               <input type="hidden" name="task_id" id="task_id" value={{$task->id}} >
               <input type="hidden" name="user_id" id="user_id" value={{$user->id}} >
                <p id="message_error_add_task" style="display: none; color: red">Merci de respecter les obligatoires !</p>
                <label for="edit_task_name">Nom * : </label> <input required class="form-control" type="text" name="edit_task_name" id="edit_task_name" value={{$task->name}}><br>
                <label for="edit_description">Description  : </label> <textarea   class="form-control"  name="edit_description" id="edit_description"  >{{$task->description}} </textarea><br>
                <div class="form-control"><label> Statut * :</label>
                <label for="edit_statut_done"> Terminée &nbsp;&nbsp; </label><input  type="radio" id="edit_statut_done" name="edit_task_statut"  value=1 {{ $task->status == 1 ? 'checked' : ''}} >
                &nbsp;&nbsp;<label for="edit_statut_not_done"> Pas encore &nbsp;&nbsp;</label><input type="radio" id="edit_statut_not_done" name="edit_task_statut" value=0 {{ $task->status == 0 ? 'checked' : ''}} >
                </div>
            <br>
            <button class="btn btn-success" type="button" name="update_task" id="update_task" style="float: right">Modifier</button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#update_task").on("click", function () {
                var task_id = $("#task_id").val();
                var user_id = $("#user_id").val();
                var edit_task_name  = $("#edit_task_name").val();
                var edit_description = $("#edit_description").val();
                var task_statut     = $('input[name="edit_task_statut"]:checked').val();

                if (!task_id || !user_id || !edit_task_name || !task_statut) {
                    $("#message_error_add_task").show();
                }else{
                    $("#message_error_add_task").hide();
                    $.ajax({
                        type: 'PUT',
                        url: '/api/tasks/'+task_id,
                        data:{
                            name         : edit_task_name,
                            description  : edit_description,
                            status       : task_statut,
                            user_id      : user_id,
                        },
                        success: function (result) {
                            window.location.href = "{{route("users_list")}}";
                        },
                        error: function (result) {
                        }
                    });
                }
            });
        });
    </script>
@stop

