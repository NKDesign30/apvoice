<?php
error_reporting(E_ALL);
require_once( dirname( __FILE__ ) . '/admin.php' );



function getCSVData($surveyId){
  $postmeta = get_post_meta($surveyId);

  global $wpdb;

  $participants = $wpdb->get_results("SELECT
                                        wpsr.*,
                                        wpu.user_email
                                      FROM
                                        {$wpdb->prefix}survey_user_results AS wpsr
                                      LEFT JOIN
                                        {$wpdb->base_prefix}users AS wpu ON wpsr.user_id = wpu.ID
                                      WHERE
                                        survey_id = $surveyId AND wpsr.is_complete = 1");
  $tableHeadlines = [];

  //print_r(maybe_unserialize($participants[0]->result));


  foreach($participants AS $value){
    $tableHeadlines['user'][$value->user_id] = $value->user_email;
    $tableHeadlines['date'][$value->user_id] = $value->created_at;
    $temp = maybe_unserialize($value->result);
  
    $chapter = 0;
    $chapter_counter = 0;
  
    if(isset($temp['is_legacy'])){
      unset($temp['is_legacy']);
      foreach($temp AS $qa){
        //if(!isset($tableHeadlines[trim($qa['question'])]))
          //echo trim($qa['question'])."\n";
        $tableHeadlines[trim($qa['question'])][$value->user_id] = $qa['answer'];
      }
    }else{
      foreach($temp AS $qa){
        if($chapter != $qa['chapter']){
          $chapter = $qa['chapter'];
          $chapter_counter = 0;
        }else{
          if(!isset($qa['parentQuestion']))
            $chapter_counter += 1;
        }

        if($qa['type'] === 'text-paragraph' || $qa['type'] === 'question_cluster')
          continue;
        elseif($qa['type'] == 'rating'){
          foreach($qa['value'] AS $k => $v){
            $chapter_dec = $qa['chapter']-1;
            $label = $postmeta["chapters_{$chapter_dec}_chapter_{$chapter_counter}_items_{$k}_headline"][0];
            if(trim($label) == "")
              $label = $qa['question'];
            $tableHeadlines[$qa['chapter'].". ".trim($label)][$value->user_id] = $v['value'];
          }
        }elseif($qa['type'] == 'choice-multi'){
          $tableHeadlines[$qa['chapter'].". ".trim($qa['question'])][$value->user_id] .= "[".implode('],[', $qa['value'])."]";
        }elseif($qa['type'] == 'matrix'){
          $tempvalue = "";
          foreach($qa['value'] AS $answer){
            if(is_array($answer['answer'])){
              $tempvalue .= $answer['question'].": "."[".implode('],[', $answer['answer'])."] | ";
            }else{
              $tempvalue .= $answer['question'].": ".$answer['answer']." | ";
            }
          }
          $tableHeadlines[$qa['chapter'].". ".trim($qa['question'])][$value->user_id] .= $tempvalue;
        }else{
          $tableHeadlines[$qa['chapter'].". ".trim($qa['question'])][$value->user_id] = $qa['value'];
        }
      }
    }
  }

  $csv_export = implode(';', array_map(function($v){ return trim($v);}, array_keys($tableHeadlines)))."\n";

  foreach($tableHeadlines['user'] AS $id => $email){
    foreach($tableHeadlines AS $head => $values){
      $csv_export .= '"'.$values[$id].'";';
    }
    $csv_export .= "\n";
  }
  return $csv_export;
}

if(isset($_GET['id'])){
  $surveyId = $_GET['id'];
  $csv_export = getCSVData($surveyId);
  $surveyTitle = get_the_title($surveyId);
  $csv_filename = 'survey_'.rawurlencode($surveyTitle).'_export.csv';

  // Export the data and prompt a csv file for download
  if(!isset($_GET['blank'])){
    header("Content-type: text/x-csv");
    header("Content-Disposition: attachment; filename=".$csv_filename."");
  }else{
    header("Content-type: text/plain");
  }
  echo($csv_export);
}else{
    $posts = get_posts([
      'post_type' => 'surveys',
      'post_status' => array('publish', 'private'),
      'numberposts' => -1
      // 'order'    => 'ASC'
    ]);

    # create new zip opbject
    $zip = new ZipArchive();

    # create a temp file & open it
    if(!is_dir(get_template_directory()."/temp")){
      mkdir(get_template_directory()."/temp");
    }
    $tmp_file = tempnam(get_template_directory()."/temp",'');
    $zip->open($tmp_file, ZipArchive::CREATE);

    # loop through each file
    foreach($posts as $post){
        $csv_export = getCSVData($post->ID);
        $csv_filename = 'survey_'.($post->post_title).'_export.csv';

        #add it to the zip
        $zip->addFromString($csv_filename,$csv_export);

    }

    # close zip
    $zip->close();

    # send the file to the browser as a download
    header('Content-disposition: attachment; filename=survey_export_'.date('Y-m-d').'.zip');
    header('Content-type: application/zip');
    readfile($tmp_file);
}
?>
