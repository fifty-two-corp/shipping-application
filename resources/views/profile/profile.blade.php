@extends('layouts.layout')

@section('content')
<div id="content" class="content">        
    <h1 class="page-header">Profile <small></small></h1>
    <div class="row">
      <div class="profile-container">
        <!-- begin profile-section -->
        <div class="profile-section">
            <!-- begin profile-left -->
            <div class="profile-left">
                <!-- begin profile-image -->
                <div class="profile-image">
                    <img src="{{ asset('photo/'.Auth::user()->photo) }}" />
                </div>
                <!-- end profile-image -->
                <div class="m-b-10" align="center">
                    <input type="file" name="image" id="image" class="jfilestyle" data-input="false" data-buttonText="Change Picture">
                </div>
            </div>
            <!-- end profile-left -->
            <!-- begin profile-right -->
            <div class="profile-right">
                <!-- begin profile-info -->
                <div class="profile-info">
                    <!-- begin table -->
                    <div class="table-responsive" style="margin-top: 15px">
                        <table class="table table-profile">
                            <tbody>
                                <tr class="highlight">
                                    <td class="field">Name</td>
                                    <td><a href="#" name="name" id="name" data-type="text" data-pk="1" data-title="Full Name" data-url="{{route('update_field')}}">{{ Auth::user()->name }}</a></td>
                                </tr>
                                <tr class="highlight">
                                    <td class="field">Name</td>
                                    <td><a href="#" name="username" id="username" data-type="text" data-pk="1" data-title="Username" data-url="{{route('update_field')}}">{{ Auth::user()->username }}</a></td>
                                </tr>
                                <tr class="highlight">
                                    <td class="field">Role</td>
                                    <td>{{ Auth::user()->roles[0]->display_name }}</td>
                                </tr>
                                <tr class="highlight">
                                    <td class="field">Email</td>
                                    <td><a href="#" name="email" id="email" data-type="text" data-pk="1" data-title="Email" data-url="{{route('update_field')}}">{{ Auth::user()->email }}</a></td>
                                </tr>
                                <tr class="highlight">
                                    <td class="field">Password</td>
                                    <td><div class="btn btn-info btn-xs" onclick="show_modal_password()">Change Password</div></td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div><!-- end table -->
                </div><!-- end profile-info -->
            </div><!-- end profile-right -->
            <div class="modal fade" id="modal_password" tabindex="-1" role="dialog" aria-labelledby="modal_password" aria-hidden="true"></div>
        </div><!-- end profile-section -->
	   </div>
    </div><!-- end row -->
</div>
@endsection

@push('js')
<script type="text/javascript">
	$(document).ready(function(){

        $("#name").editable();
        $("#username").editable();
        $("#email").editable();
        $(function() {
            $("input:file").change(function (){
                var fileName = $(this).val();
                $(".filename").html(fileName);
            });
	   });

        $(document).on('change', '#image', function(){
            var name = $('#image')[0].files[0].name;
            var ext = name.split('.').pop().toLowerCase();
            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                alert("Invalid Image File");
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL($('#image')[0].files[0]);
            var f = $('#image')[0].files[0];
            var fsize = f.size||f.fileSize;
            if(fsize > 2000000) {
                alert("Image File Size is very big");
            } else {
                $.ajaxSetup({
                    header:$('meta[name="_token"]').attr('content')
                })
                var image = $('#image')[0].files[0];
                var form_data = new FormData();
                form_data.append('image', image);
                form_data.append('ext', ext);
    		  	$.ajax({
                    url: 'profile/photo/store',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success:function(response) {
                        //console.log(response);
                        location.reload();
                    }
    		    });
            }
        });
    });

    function show_modal_password() {
      $.ajax({
        type:"GET",
        url: "profile/update_password",
        success: function(res) {
          $('#modal_password').html(res);
          $('#modal_password').modal('show');
        }
      });
    }

    function save_password(){
      $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
      })
      $.ajax({
        type:"POST",
        url:'profile/store_password',
        data:$('#form-password').serialize(),
        dataType: 'json',
        success: function(data){
          $('#modal_password').modal('hide');
          swal('Password Change','','success');
        },
          error: function(data){
            $('#password-allert').removeAttr('hidden');
        }
      })
    };
</script>
@endpush