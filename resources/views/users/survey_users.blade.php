@extends('layouts.reports') 
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

@if (\Auth::check() && \Auth::user()->hasPermission('surveyUsers', $survey))
<div id="HelpContent" class="modal-body" style="display:none;">
<p><b>Project users</b></p>
<p>
When you select project users, you are presented with a screen that displays the individuals who
have access to this particular project. In this, you can not only add and modify these individual
users, but you can also modify their rights, such as what parts of the portals they are able to see,
and permissions that they have. If you are not a super user, this tab is where you would manage
the specific project that you have access to. The features available to you are create user, csv,
pdf, and add a user to survey.
</p>
<img src="{{asset('imgs/user-guide/image-002.png')}}">
<p>
The Create User button allows for you to create a completely new individual from scratch that
will be added to this project. You also have the option to create a CSV file within this tab, which
allows you to create a datatable with columns and rows, using the information that is presented
on this screen. Should you choose to do so, you are presented with the option to download a pdf
file, which will capture the information that is shown on your screen. The Add User to Survey
button allows you to add a user who already exists in the database to the project.
</p>


      </div>
<div class="container" id="pdfhidden">
    <div id="survey_users_pdflogo"><img class="" src="{{asset('imgs/revel-logo.png')}}"></div>

    <div class="row alert alert-dismissible" id="message_flash_row" style="display: none;">
        <div class="col-12">
            <h3 id="message_flash_text "></h3>
        </div>
    </div>
    <div class="cont-mtitle mt-8 mt-8 flex flex-wrap justify-between items-center">
        <h1 class="text-survey">{{ $survey->survey_name }} Users</h3>
        <button type="button" class="helpguidebtn mx-2" data-toggle="modal" data-target="#helpdetasurvey">         
</button> 
    </div>
    <div class="projectuser-cont">
        <div class="row " id="controlsRow">
            <div class="col-sm-3 col-5 text-right text-sm-left pr-2 pr-sm-0">
                {{-- <div class="bg-grey-light h-12 text-right text-md-left"> --}}
                <button class="text-white" id="btnAddNewUser">
                    Create User
                </button>
                {{-- </div> --}}
            </div>
            <div class="col-sm-4 text-cener  col-7 user-downbtns">
                @if (\Auth::check() && \Auth::user()->hasPermission('surveyExport', $survey))
                <a id="exportUsersCsv" href="{{ action([\App\Http\Controllers\UserController::class, 'exportUsers'], $data['survey']->survey_id) }}" class="">
                    <i class="fa fa-download"></i>CSV
                </a>
                @endif
                @if (\Auth::check() && \Auth::user()->hasPermission('surveyPrint', $survey))
                <button class="text-white" id="exportUsersPdf">
                    <i class="fa fa-download"></i>PDF
                </button>
                @endif
            </div>
            <div class="col-sm-5 col-12 pt-2 pt-sm-0 mx-auto text-center text-sm-right seluser-addsurvay">
                {{-- <div class="bg-grey-light h-12"> --}}
                @if (\Auth::check() && \Auth::user()->is_admin)
                <select id="currentUsers" class="">
                    <option>Add User to Survey</option>
                    @foreach ($data['allUsers'] as $user)
                    <option value="{{ $user->id }}">{{ $user->last_name }}, {{ $user->first_name }}
                    </option>
                    @endforeach
                </select>
                <button class="" id="btnAddExistingUser">
                    Add
                </button>
                @endif
            </div>
        </div>

        <div class="puser-table table-responsive"> 
            @if ($data['users'])
            <table id="table_survey_users" class="table  table-txtmid table-striped" id="user_table"> 
                <thead>
                    <tr>
                        <th class="hide-column">Edit User</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Last Login</th>
                        <th>Duration (hh:mm:ss)</th>
                    </tr>
                </thead>
                <tbody id="user_table_body">
                    @foreach ($data['users'] as $user) 
                    <tr id="user_entry_{{ $user->id }}">
                        <td class="hide-column">
                            <button class="fas fa-edit mx-auto table-midbtn btn-revelation-primary" id="edit_user_{{ $user->id }}" data-user_id="{{ $user->id }}"></button>
                            <button class="fas fa-trash-alt table-midbtn btn-revelation-primary" id="delete_user_{{ $user->id }}" data-user_id="{{ $user->id }}"></button>
                        </td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->last_login }}</td>
                        <td>{{ $user->logged_out_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h4>Currently, there are no users assigned to this survey.</h4>
            @endif
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="helpdetasurvey" tabindex="-1" aria-labelledby="exampleModalCenterTitle"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header align-items-center">
        <h5 class="modal-title" id="exampleModalCenterTitle">User Guide</h5> 
        <button class="revnor-btn ml-auto mr-2 mb-3 mb-md-0 bg-white text-dark" id="printHelp">Print</button> 
        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <p>
When you select project users, you are presented with a screen that displays the individuals who
have access to this particular project. In this, you can not only add and modify these individual
users, but you can also modify their rights, such as what parts of the portals they are able to see,
and permissions that they have. If you are not a super user, this tab is where you would manage
the specific project that you have access to. The features available to you are create user, csv,
pdf, and add a user to survey.
</p>
<img src="{{asset('imgs/user-guide/image-002.png')}}">
<p>
The Create User button allows for you to create a completely new individual from scratch that
will be added to this project. You also have the option to create a CSV file within this tab, which
allows you to create a datatable with columns and rows, using the information that is presented
on this screen. Should you choose to do so, you are presented with the option to download a pdf
file, which will capture the information that is shown on your screen. The Add User to Survey
button allows you to add a user who already exists in the database to the project.
</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 


<!--- help data popup end ---->
<div class="modal fade" tabindex="-1" role="dialog" id="addNewUser" aria-labelledby="New User" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-notify modal-warning" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header text-center rl-modal-header">
                <h4 id="manage_user_title" class="modal-title white-text w-100 font-weight-bold py-2">Add User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body" style="height: 50vh; overflow-y: auto;">
                <input type="hidden" id="user_id" name="user_id" value="">
                <div class="md-form mb-2">
                    <label data-error="wrong" data-success="right" for="first_name">First Name</label>
                    <input type="text" id="first_name" class="form-control validate" placeholder="First Name">
                </div>
                <div class="md-form mb-2">
                    <label data-error="wrong" data-success="right" for="last_name">Last Name</label>
                    <input type="text" id="last_name" class="form-control validate" placeholder="Last Name">
                </div>
                <div class="md-form mb-2">
                    <label data-error="wrong" data-success="right" for="email">Email</label>
                    <input type="email" id="email" class="form-control validate" placeholder="Email">
                </div>
                <div class="md-form mb-2">
                    <label data-error="wrong" data-success="right" for="username">Username</label>
                    <input type="text" id="username" class="form-control validate" placeholder="Username">
                </div>
                <div class="md-form mb-2">
                    <label data-error="wrong" data-success="right" for="password">Password</label>
                    <input type="password" id="password" class="form-control validate" placeholder="Password - Leave empty to keep current password">
                </div>
                <hr>
                <div class="userpopinliit">
                <label>Allowed Departments</label><input type="checkbox" id="SelectAllDepartments"> <span>Select All</span>
                </div> 
                <select id="departments" name="departments[]" multiple="multiple" class="form-control" style="display: block;">
                    @foreach ($departments as $department)
                    <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
                <div class="userpopinliit">
                <label>Allowed Locations</label> <input type="checkbox" id="SelectAllLocations"> <span>Select All</span> 
                    </div>
                <select id="locations" name="locations[]" multiple="multiple" class="form-control" style="display: block;">
                    @foreach ($locations
                    as $location)
                    <option value="{{ $location }}">
                        {{ $location }}
                    </option>
                    @endforeach
                </select>
                <div class="userpopinliit">
                <label >Project Permissions</label> <input type="checkbox" id="SelectAllPermissions"> <span>Select All</span>
                </div>
                <select id="permissions" name="permissions[]" multiple="multiple" class="form-control" style="display: block;">


                    @foreach (App\Models\Permission::all()->unique('name')->sortBy('name')
                    as $permission)
                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                    @endforeach
                </select>

                {{-- <label class="">
                            <input class="" type="checkbox" checked="true" readonly name="permissions[surveyHome]" id="surveyHome" /> Status
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveyUsers]" id="surveyUsers" /> Users
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveyContent]" id="surveyContent" /> Taxonomy
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveySettings]" id="surveySettings" /> Settings
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveyRespondents]" id="surveyRespondents" /> Participants
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveyInvitations]" id="surveyInvitations" /> Invitations
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveyReports]" id="surveyReports" /> Reports
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveyNoCompReport]" id="surveyNoCompReports" /> NC Reports
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveyAnalysis]" id="surveyAnalysis" /> Analysis
                        </label>
                        <label class="">
                            <input class="" type="checkbox" name="permissions[surveyRealEstate]" id="surveyRealEstate" /> Real Estate
                        </label> --}}
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button class="btn rounded waves-effect text-white" id="saveUser" style="background: #008EC1;">Save
                    <i class="fa fa-paper-plane ml-1"></i></button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
@else

<script>
    Swal.fire({
        title: 'Permissions Required',
        text: 'You do not have permissions to view this page.',
        icon: 'error',
        confirmButtonText: 'OK',
    });
</script>


@endif

{{-- <div class="text-center"> --}}
{{-- <a href="" class="btn btn-default btn-rounded" data-toggle="modal" data-target="#orangeModalSubscription">Launch --}}
{{-- modal Subscription</a> --}}
{{-- </div> --}}

<script>
 
        $('#printHelp').on('click', function(){
            
            // var respondent_name_print = $('#respondent_data').find('h3').text();
            // if(respondent_name_print != ''){

            $('#headerDiv').show();
            $('#hiddenprint').hide();
            $('.modal-backdrop').hide();
            $('#helpdetasurvey').modal('hide');
            $('#pdfhidden').hide();
            // $('#helpdetasurvey').hide();
            $('#HelpContent').show();
            $('#copyright_div').addClass('fixedbottompdf');
            $('#headerDiv').addClass('fixedtoppdf');
            $(".entrymain-content")[0].style.minHeight = "0";
            const hideElements = ['#desktop_sidebar','#hideinpdf', '.site-footer','.site-header','.first_part', '#pdfPrint', 'header > div > ul'];

            $.each(hideElements, function(_, el){ $(el).hide(); });

            window.print();

            $.each(hideElements, function(_, el){ $(el).show(); });
            
            $('#headerDiv').hide();
            $('#HelpContent').hide();
            $('#hiddenprint').show();
            $('#pdfhidden').show();
           // $('#helpdetasurvey').show();
            $('#copyright_div').removeClass('fixedbottompdf');
            $('#headerDiv').removeClass('fixedtoppdf');
            $(".entrymain-content")[0].style.minHeight = "100vh";
           /*  }else{ 
                $('#selectRespModal').modal();

            } */

           
        });  

    $(document).ready(() => {

        
        $("#SelectAllDepartments").on('change',function(){
           

            // $('#departments').select2();

            if($("#SelectAllDepartments").is(':checked') ){
                // alert('test');
                $('#departments').select2('destroy').find('option').prop('selected', 'selected').end().select2();
                /* $("#departments > option").prop("selected","selected");
                $("#departments").trigger("change"); */
            }else{
                // alert('testnot');
                $('#departments').select2('destroy').find('option').prop('selected', false).end().select2();
                /* $("#departments > option").removeAttr("selected");
                $("#departments").trigger("change"); */
            }
        });
        $("#SelectAllPermissions").on('change',function(){
           

            // $('#departments').select2();

            if($("#SelectAllPermissions").is(':checked') ){
                // alert('test');
                $('#permissions').select2('destroy').find('option').prop('selected', 'selected').end().select2();
                /* $("#departments > option").prop("selected","selected");
                $("#departments").trigger("change"); */
            }else{
                // alert('testnot');
                $('#permissions').select2('destroy').find('option').prop('selected', false).end().select2();
                /* $("#departments > option").removeAttr("selected");
                $("#departments").trigger("change"); */
            }
        });
        $("#SelectAllLocations").on('change',function(){
           

            // $('#departments').select2();

            if($("#SelectAllLocations").is(':checked') ){
                // alert('test');
                $('#locations').select2('destroy').find('option').prop('selected', 'selected').end().select2();
                /* $("#departments > option").prop("selected","selected");
                $("#departments").trigger("change"); */
            }else{
                // alert('testnot');
                $('#locations').select2('destroy').find('option').prop('selected', false).end().select2();
                /* $("#departments > option").removeAttr("selected");
                $("#departments").trigger("change"); */
            }
        });

        $('#table_survey_users').DataTable({
            searching: true,
            "bLengthChange": true,
            'pageLength': 25,
            'lengthMenu': [[25, 50, 100], [25, 50, 100]],
            "fnDrawCallback": function(oSettings) {
                if ($('#table_survey_users tr').length < 25) {
                    $('#table_survey_users_info').hide();
                    $('#table_survey_users_paginate').hide();
                    $('#table_survey_users_length').hide();
                }
            }
        });

        $('input[name="table_survey_users_length"]').css('width', '3.5rem');

    })
</script>
@if (\Auth::check() && \Auth::user()->hasPermission('surveyUsers', $survey))
<script type="text/javascript">
    const survey_id = "{{ $survey->survey_id }}";
    var departments_data, locations_data, permissions_data;
    $(function() {
        departments_data = $('#departments').html();
        locations_data = $('#locations').html();
        permissions_data = $('#permissions').html();

        if ({{count($data['users'])}} > 0) {}

        $("#btnAddNewUser").on('click', function() {
            clearUserForm();
            $('#manage_user_title').text('Create User');
            $("#addNewUser").modal('show');

            // Initialize select2
            $('#departments').html(departments_data);
            $('#permissions').html(permissions_data);
            $('#locations').html(locations_data);

            $('#departments').select2({
                width: '100%'
            });
            $('#permissions').select2({
                width: '100%'
            });
            $('#locations').select2({
                width: '100%'
            });
        });

        $('#saveUser').on('click', function() {
            saveUser();
        });

        $('#btnAddExistingUser').on('click', function() {
            addUser($('#currentUsers').val());
        });

        $('#exportUsersPdf').on('click', printUserTable);

        // delegate event handling to the dom to catch events from users added by the js
        $(document).on('click', '[id^="edit_user_"]', function() {
            $('#manage_user_title').text('Edit User');
            loadUser($(this).data('user_id'));
        });

        $(document).on('click', '[id^="delete_user_"]', function() {
            removeUser($(this).data('user_id'),'{{$survey->survey_id}}');
        });

        $('#departments').select2({
            width: '100%'
        });
        $('#permissions').select2({
            width: '100%'
        });
        $('#locations').select2({
            width: '100%'
        });

    });

    function removeUser(userId,survey_id) {
        //alert(survey_id);
        Swal.fire({
            title: 'Are you sure you want to remove this user?<br>This cannot be undone.',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: `Continue`,
            cancelButtonText: `Cancel`,
            reverseButtons: true,
            icon: 'warning',
        }).then(function(result) {
            if (result.isConfirmed) {
                showLoader();
                $.post('{{url("/")}}/users/remove/' + userId, {survey_id:survey_id})
                    .done(function($data) {
                        hideLoader();
                        Swal.fire({
                            title: 'Success!',
                            text: 'User has been removed successfully',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        });
                        $('#user_entry_' + userId).remove();
                    })
                    .fail(handleError);
            }
        })
    }

    function clearUserForm() {
        $('#departments, #permissions, #locations').val(null).trigger('change')
        $('#first_name').val('');
        $('#last_name').val('');
        $('#email').val('');
        $('#username').val('');
        $('#password').val('');
        $('#user_id').val('');
    }

    function addUser(user_id) {
        showLoader();
        $.post('{{url("/")}}/users/add-to-survey', {
                user_id,
                survey_id
            })
            .done(function(data) {
                hideLoader();
                Swal.fire("User Added", "User now has access to this survey.", "success");
                addUserToTable(data);
            })
            .fail(handleError);
    }

    function loadUser(userId) { 
        showLoader();
        clearUserForm();
        $.get('{{url("/")}}/users/fetch/' + userId, {survey_id:'{{$survey->survey_id}}'})
            .done(function(data) {

                console.log(data.departments);
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#email').val(data.email);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#user_id').val(data.id);
                $("#addNewUser").modal('show');
                // Initialize select2
                $('#departments').empty();
                $('#permissions').empty();
                $('#locations').empty();

                $('#departments').select2({
                    data: data.departments,
                    width: '100%' 
                });

                $('#permissions').select2({
                    data: data.permissions,
                    width: '100%'
                });

                $('#locations').select2({
                    data: data.locations,
                    width: '100%'
                });

                hideLoader();
            })
            .fail(handleError);
    }

    function saveUser() {
        const first_name = $('#first_name').val();
        const last_name = $('#last_name').val();
        const email = $('#email').val();
        const username = $('#username').val();
        const password = $('#password').val();
        let permissions = [];
        let departments = [];
        let locations = [];
        const userId = $('#user_id').val();


        $.each($('#departments').select2('data'), function() {
            departments.push(this.text);
        });

        $.each($('#permissions').select2('data'), function() {
            permissions.push(this.text);
        });

        $.each($('#locations').select2('data'), function() {
            locations.push(this.text);
        });

        if (!first_name) {
            Swal.fire({
                title: 'Missing Field',
                text: 'First name is required.'
            }, function() {
                setTimeout(function() {
                    $('#first_name').focus();
                })
            });
            return;
        } else if (!last_name) {
            Swal.fire({
                title: 'Missing Field',
                text: 'Last name is required.'
            }, function() {
                setTimeout(function() {
                    $('#last_name').focus();
                })
            });
            return;
        } else if (!first_name) {
            Swal.fire({
                title: 'Missing Field',
                text: 'Email address is required.'
            }, function() {
                setTimeout(function() {
                    $('#email').focus();
                })
            });
            return;
        } else if (!username) {
            Swal.fire({
                title: 'Missing Field',
                text: 'Username is required.'
            }, function() {
                setTimeout(function() {
                    $('#username').focus();
                })
            });
            return;
        } else if (!password) {
            if (!userId) {
                Swal.fire({
                    title: 'Missing Field',
                    text: 'Password is required.'
                }, function() {
                    setTimeout(function() {
                        $('#password').focus();
                    })
                });
                return;
            }
        };

        showLoader();

        if (userId)
            updateUser(first_name, last_name, email, password, username, survey_id, permissions, departments, locations,
                userId);
        else
            createUser(first_name, last_name, email, password, username, survey_id, permissions, departments,
                locations);
    }

    function createUser(first_name, last_name, email, password, username, survey_id, permissions, departments,
        locations) {
        $.post('{{url("/")}}/users/create', {
                first_name,
                last_name,
                email,
                password,
                username,
                survey_id,
                permissions,
                departments,
                locations
            })
            .done(function(data) {
                hideLoader();
                $("#addNewUser").modal('hide');
                Swal.fire("User Created", "This user is now part of this survey.", "success");
                addUserToTable(data)
            })
            .fail(handleError);
    }

    function updateUser(first_name, last_name, email, password, username, survey_id, permissions, departments,
        locations, userId) {
        $.post('{{url("/")}}/users/update/' + userId, {
                first_name,
                last_name,
                email,
                password,
                username,
                survey_id,
                permissions,
                departments,
                locations
            })
            .done(function(data) {
                hideLoader();
                $("#addNewUser").modal('hide');
                Swal.fire({
                        title: "User Updated",
                        text: "Press OK to reload changes.",
                        icon: "success"
                    })
                    .then(function() {
                        window.location.reload();
                    }, 100)
            })
            .fail(handleError);

    }

    function addUserToTable(data) {
        $('#user_table_body').append(`
                    <tr id="user_entry_${data.id}">
                        <td class="hide-column">
                            <button class="fas fa-edit mx-auto btn rounded btn-revelation-primary" id="edit_user_${data.id}" data-user_id="${data.id}"></button>
                            <button class="fas fa-trash-alt mx-auto btn rounded btn-revelation-primary" id="delete_user_${data.id}" data-user_id="${data.id}"></button>
                        </td>
                        <td>${data.first_name}</td>
                        <td>${data.last_name}</td>
                        <td>${data.username}</td>
                        <td>${data.email}</td>
                        <td>${data.last_login ? data.last_login : ''}</td>
                    </tr>
                `);

        $('#currentUsers').find(`option[value="${data.id}"]`).remove();
    }

    function handleError(data, text, error) {

        hideLoader();
        console.log(data, text, error);
        let messages = JSON.parse(data.responseText);
        let str_msg = 'The following errors occured. Please adjust and try again.\r\n';
        for (const message in messages.errors) {
            str_msg += messages.errors[message][0] + '\r\n';
        }

        Swal.fire({
            title: "Oops, something went wrong",
            text: str_msg,
            icon: "error",
            button: "OK",
        });
    }

    function printUserTable() {
        const hideElements = ['#desktop_sidebar', '.hide-column', '#pdfPrint', 'header > div > ul', '#controlsRow','.site-footer','#table_survey_users_filter','#header','#table_survey_users_info','#table_survey_users_paginate'];

        $.each(hideElements, function(_, el) {
            $(el).hide();
        });

        window.print();

        $.each(hideElements, function(_, el) {
            $(el).show();
        });
    }
</script>
@endif

@include('partials.loader')
@endsection