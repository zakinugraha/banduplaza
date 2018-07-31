  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Instagram Account
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Instagram</a></li>
        <li class="active">Manage</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
          
        
        
        <div class="col-md-12">
            
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $_SESSION['insta_login']->user->username;?></h3>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="box-body box-profile" id="box-profile">
                          <img class="profile-user-img img-responsive img-circle" src="<?= $_SESSION['insta_login']->user->profile_picture ?>" alt="User profile picture">
        
                          <input type="hidden" name="token" id="access_token" value="<?php echo $_SESSION['insta_login']->access_token;?>">
        
                          <p class="text-muted text-center"><?php echo $_SESSION['insta_login']->user->full_name;?></p>
                          <p class="text-muted text-center"><?php echo $_SESSION['insta_login']->user->bio;?></p>
                          <a href="<?php echo $_SESSION['insta_login']->user->website;?>" target="_BLANK"><p class="text-center"><?php echo $_SESSION['insta_login']->user->website;?></p></a>
        
                          <ul class="list-group list-group-unbordered" style="padding-top:10px;">
                            <li class="list-group-item">
                              <b>Post</b> <a class="pull-right">141</a>
                            </li>
                            <li class="list-group-item">
                              <b>Followers</b> <a class="pull-right">2548</a>
                            </li>
                            <li class="list-group-item">
                              <b>Following</b> <a class="pull-right">4879</a>
                            </li>
                          </ul>
        
                          <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                        </div>
                        <!-- /.box-body -->
        
                      </div>
                      <!-- /.col -->
                      
                      <div class="col-md-9">
                        <div class="box-header with-border" style="border-left:1px solid #e3e3e3 !important;">
                          <h3 class="box-title">Post Media</h3>
                        </div>
                        <div id="loading" style="display:block;text-align:center;"><img src="<?php echo base_url();?>assets/admin/img/loading_spinner.gif" style="margin-top:30px;width:70px"></div>
                        <ul class="users-list clearfix" style="max-height:600px;overflow:auto;border-left:1px solid #e3e3e3 !important;" id="instagram-media"></ul>
                      </div> 
                            
                </div>
                
            </div>
            
        </div> <!-- /.col -->
        
      </div> <!-- /.row -->
    </section>

  </div>
  <!-- /.content-wrapper -->
  
    <div class="modal fade" id="show-detail">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Box Comment -->
          <div class="box box-widget">
              <div class="box-header with-border">
                  <div class="box-header with-border">
                      <div class="user-block">
                        <img class="img-circle" id="img-profile" class="img-responsive">
                        <span class="username"><a href="#" id="username"></a></span>
                        <span class="description" id="fullname"></span>
                      </div>
                  </div>
                  <div class="box-body">
                    <img id="post_images" name="post_images" class="img-responsive" style="padding:0 0 10px 0">
                    <p id="caption"></p>
                    <span class="pull-right text-muted" id="view_comments_count" style="font-size:16px"></span>
                    <span class="pull-right text-muted" id="view_likes_count" style="font-size:16px;margin-right:13px"></span>
                  </div>
                  
                  <div class="box-footer box-comments" style="padding:10px">
                      <div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="https://scontent.cdninstagram.com/vp/686d8ed737fdc355ad350e2d450de067/5B4F0C7A/t51.2885-19/s150x150/13534488_461607727560604_3029637589494661120_a.jpg" alt="User Image">
        
                        <div class="comment-text">
                              <strong><span id="comment_name">Zaki</span></strong><!-- /.username -->
                              <span class="text-muted pull-right" id="comment_date">18 April 2018</span>                      
                              <span id="comment_text" style="display:block;">Cool!</span>                  
                        </div>
                        <!-- /.comment-text -->
                      </div>
                      <!-- /.box-comment -->
                      
                  </div>
                  <!-- /.box-footer -->
                    
              </div>
                
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

  <script type="text/javascript">
    jQuery(document).ready(function(e) {
      $token = $('#access_token').val();

      // Get Followers Count
      jQuery.ajax({
        method : "GET",
        url : 'https://api.instagram.com/v1/users/self/?access_token='+$token,
        dataType : "jsonp",
        jsonp : "callback",
        success : function(data) {
        //   console.log(data);
          jQuery('#media').append(data.data.counts.media);
          jQuery('#followers').append(data.data.counts.followed_by);
          jQuery('#following').append(data.data.counts.follows);
        }
      });
      // End Get Followers Count

      // Get Media
      
      var media = $('#instagram-media');
      jQuery.ajax({
        method : "GET",
        url : 'https://api.instagram.com/v1/users/self/media/recent/?access_token='+$token,
        dataType : "jsonp",
        success : function(res) {
            console.log(res.data);
            var i;
            for (i = 0; i < res.data.length; i++) { 
                // console.log(res.data[i]);
                var text = '<li class="media-post">'+
                            '<a href="javascript:show_post('+ i +')">'+
                            '<img src="'+res.data[i].images.low_resolution.url+'" class="img-responsive">'+
                            '<div class="back"><div class="count">'+
                            '<ul>'+
                              '<li><i class="fa fa-heart-o"></i> '+res.data[i].likes.count+'</li>'+
                              '<li><i class="fa fa-comment-o"></i> '+res.data[i].comments.count+'</li>'+
                            '</ul>'+
                            '</div></div>'+
                            '</a>'+
                            '<textarea type="hidden" id="data-'+ i +'" style="display:none">'+JSON.stringify(res.data[i])+'</textarea>'+
                            '</li>';
                
                media.append(text);
                $("#loading").hide();
            }
        }
      });
      // End Get Media
      
      

    });
    
    function show_post(data_id){
        
        var data = $('#data-'+data_id).val();
        data = $.parseJSON(data);
        $('#username').append(data.user.username);
        $('#fullname').append(data.user.full_name);
        $('#caption').append(data.caption.text);
        $('#view_comments_count').append('<i class="fa fa-comment-o"></i> '+data.comments.count);
        $('#view_likes_count').append('<i class="fa fa-heart-o"></i> '+data.likes.count);
        document.getElementById("post_images").src = data.images.standard_resolution.url;
        document.getElementById("img-profile").src = data.user.profile_picture;
        $('#show-detail').modal('show');
        
        // Get Comments
        var token = $('#access_token').val();
        var media_id = data.id;
        jQuery.ajax({
            method : "GET",
            url : 'https://api.instagram.com/v1/media/'+media_id+'/comments?access_token='+token,
            dataType : "jsonp",
            success : function(response) {
                console.log(response);
            }
        });
        // End Get Comments

    }
    
    $(function () {
    // when the modal is closed
    $('#show-detail').on('hidden.bs.modal', function () {
      $(this).removeData('bs.modal');
      $("#username").empty();
      $("#fullname").empty();
      $("#caption").empty();
      $("#view_comments_count").empty();
      $("#view_likes_count").empty();
    });

  });

  </script>