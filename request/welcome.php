<?php
ob_start();
session_start();
include_once("../includes/config.php");
$settings = mysql_fetch_array(mysql_query("SELECT * from settings"));

include_once("../includes/welcome.php");
// isset of load more
if(!empty($_POST['loadmore'])) {
	 $load = $_POST['loadmore'];
	 $end = $load + 5;
$main_array_new = array_slice($main_array, $load, 5,true);

foreach ($main_array_new as $id){
		// main array
           if ($id['table'] == "announcement") {
					$up = mysql_fetch_array(mysql_query("SELECT * FROM announcement WHERE ann_id='".$id['id']."'"));
		  echo '<div class="feed-item feed-item-question">
                <div class="feed-icon"><i class="fa fa-volume-up"></i></div>
                <div class="feed-subject">
                  <p><strong>Announcement Title: </strong><a href="'.$conf_path.'/announcement.php?view='.base64_encode(base64_encode($id['id'])).'">'.$up['title'].'</a></p>
                </div> <!-- /.feed-subject -->

                <div class="feed-content">
                  <ul class="icons-list">
                    <li><i class="fa fa-info-circle"></i> <strong>Announcement Info:</strong>'.$up['content'].'</li>
                  </ul>
                </div> <!-- /.feed-content -->

                <div class="feed-actions">
                  <a href="'.$conf_path.'/announcement.php?view='.base64_encode(base64_encode($id['id'])).'" class="pull-left"><i class="fa fa-external-link"></i> View</a> 
                  <a class="pull-right"><i class="fa fa-clock-o"></i> '.$up['display_from'].' | '.$up['display_to'].'</a>
                </div> <!-- /.feed-actions -->

              </div> <!-- /.feed-item -->';
			} if ($id['table'] == "appreciation") {
					$up = mysql_fetch_array(mysql_query("SELECT * FROM appreciation WHERE app_id='".$id['id']."'"));

             echo '<div class="feed-item feed-item-file">
                <div class="feed-icon"><i class="fa fa-star"></i></div> <!-- /.feed-icon -->
                <div class="feed-subject">
                  <p> <strong>Appreciation to:</strong> <a href="'.$conf_path.'/appreciation.php?view='.base64_encode(base64_encode($id['id'])).'">'.$up['app_name'].'</a></p>
                </div> <!-- /.feed-subject -->

                <div class="feed-content">
                  <ul class="icons-list">
                  	<li><i class="fa fa-info-circle"></i> <strong>Designation:</strong> '.$up['app_designation'].'</li>
                    <li><i class="fa fa-info-circle"></i> <strong>Appreciation Information:</strong>
                      '.$up['app_details'].'
                    </li>
                  </ul>
                  <div class="thumbnail"  style="border:none">
                    <div class="thumbnail-view"  style="cursor: inherit;">
                            <img alt="Gallery Image" src="'.$conf_path.'/'.$up['app_img'].'">
                        </div>
                  </div>
                </div> <!-- /.feed-content -->

                <div class="feed-actions">
                  <a href="'.$conf_path.'/appreciation.php?view='.base64_encode(base64_encode($id['id'])).'" class="pull-left"><i class="fa fa-external-link"></i> View</a> 
                  <a href="javascript:;" class="pull-right"><i class="fa fa-clock-o"></i> '.$up['display_date'].'</a>
                </div> <!-- /.feed-actions -->

              </div> <!-- /.feed-item -->';
			} if ($id['table'] == "thoughts") {
					$up = mysql_fetch_array(mysql_query("SELECT * FROM thoughts WHERE 	tid='".$id['id']."'"));
              echo '<div class="feed-item feed-item-bookmark">
                <div class="feed-icon"><i class="fa fa-comment"></i></div> <!-- /.feed-icon -->
                <div class="feed-subject">
                  <p><strong>Thoughts Title:</strong> <a href="'.$conf_path.'/thought-of-the-day.php?view='.base64_encode(base64_encode($id['id'])).'">'.$up['t_title'].'</a></p>
                </div> <!-- /.feed-subject -->

                <div class="feed-content">
                  <ul class="icons-list">
                    <li><i class="fa fa-info-circle"></i>
                     <strong> About Thoughts: </strong>'.$up['t_details'].'
                    </li>
                  </ul>
                  <div class="thumbnail"  style="border:none">
                    <div class="thumbnail-view"  style="cursor: inherit;">
                            <img alt="Gallery Image" src="'.$conf_path.'/'.$up['t_img'].'">
                        </div>
                  </div>
                </div> <!-- /.feed-content -->

                <div class="feed-actions">
                  <a href="'.$conf_path.'/thought-of-the-day.php?view='.base64_encode(base64_encode($id['id'])).'" class="pull-left"><i class="fa fa-external-link"></i> View</a> 
                  <a class="pull-right"><i class="fa fa-clock-o"></i> '.$up['display_date'].'</a>
                </div> <!-- /.feed-actions -->

              </div> <!-- /.feed-item -->';
			} 
           
}

if(sizeof($main_array) > $end){
echo '<p id="more'.$end.'"><button class="btn btn-success moreinfo" id="'.$end.'" type="button" style="width:100%"><i class="fa fa-spinner  fa-spin"></i> Click here to load more</button></p>';
 } else {
echo '<p id="more"><button class="btn btn-success" type="button" style="width:100%"> No More results</button></p>';
 }
}

?>