<?php
error_reporting(E_ALL);
require_once( dirname( __FILE__ ) . '/admin.php' );


global $wpdb;

$participants = $wpdb->get_results("SELECT
                                      wptr.*,
                                      wpu.user_email,
                                      wpp.post_title
                                    FROM
                                      {$wpdb->prefix}training_question_user_results AS wptr
                                    LEFT JOIN
                                      {$wpdb->base_prefix}users AS wpu ON wptr.user_id = wpu.ID
                                    LEFT JOIN
                                      {$wpdb->prefix}posts AS wpp ON wptr.training_id = wpp.ID
                                    WHERE
                                      wptr.question_type = 'rating' OR wptr.question_type = 'choice' ORDER BY user_id DESC");
$tableHeadlines = [];
$csv_filename = 'training_export_'.date('Y-m-d').'.csv';


//print_r(maybe_unserialize($participants[0]->result));

$questionArr = array();
$answerArr = array();

foreach($participants AS $value){
  $result = maybe_unserialize($value->result)[0];

  if(!isset($questionArr[$value->question_id]))
    $questionArr[$value->question_id] = $result['question'];

  if(!isset($answerArr[$value->user_id."-".$value->training_id])){
    $answerArr[$value->user_id."-".$value->training_id] = array(
      'email' => $value->user_email,
      'training' => $value->post_title,
      'date' => $value->created_at,
      'question_type' => $value->question_type,
      'questions' => array()
    );
  }

  $answerArr[$value->user_id."-".$value->training_id]['questions'][$value->question_id] = $result['user_answer']['value'];
  
  //$csv_export .= $value->user_email.";\"".$value->post_title."\";\"".$result['question']."\";".$result['user_answer']['value'].";".$value->created_at."\n";
}

$csv_export = "email;training;type;date;\"".implode('";"', $questionArr)."\"\n";

foreach($answerArr as $answer){
  $csv_export .= $answer['email'].";\"".$answer['training']."\";\"".$answer['question_type']."\";\"".$answer['date']."\"";
  foreach($questionArr as $key => $value){
    $csv_export .= ";".(isset($answer['questions'][$key]) ? $answer['questions'][$key] : "");
  }
  $csv_export .= "\n";
}

// Export the data and prompt a csv file for download
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);

?>
