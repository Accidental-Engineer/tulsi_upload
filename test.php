<?php
// start_session();
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;
$client = ClientBuilder::create()
    ->addConnection('bolt', 'bolt://neo4j:123@localhost:7687')
    ->build();
if (isset($_POST['userResponse']) && $_POST['userResponse'] !="") {
  //echo $_POST['id'];
  if ($_POST['id']=="symptom") {
    $symptom = $_POST['userResponse'];
    $q_id = "match (s:SYMPTOM)-[:OPTION]->(q:QUESTION) where s.value='".$symptom."' return ID(q) as id";
    $result_id = $client->run($q_id);
    $id = $result_id->getRecord()->value('id');
  }
  else {
    $id = $_POST['id'];
    $q_id = "match (:QUESTION)-[r:OPTION]->(q:QUESTION) where ID(r) =".$id." return ID(q) as id";
    $result_id = $client->run($q_id);
    $id = $result_id->getRecord()->value('id');
    //echo $id;
  }
  $q = "match (q:QUESTION) where ID(q)=".$id." return q.value as question";
  $o = "match (q0:QUESTION)-[r:OPTION]->(q1:QUESTION) where ID(q0)=".$id." return ID(r) as id, r.value as options";
  $result_q = $client->run($q);
  $result_o = $client->run($o);
  $JSON_responce = "{\"question\":";
  foreach ($result_q->getRecords() as $record_q) {
      $question=$record_q->value('question');
      $options="{";
      $i = 1;
      foreach ( $result_o->getRecords() as $record_o) {
        if($i!=1) $options .= "," ;
        $options .= "\"".$record_o->value('options')."\":".$record_o->value('id')."";
        $i++;
      }
      $options .="}";
  $JSON_responce .= "\"".$question."\"".",\"options\":".$options."}";
  echo $JSON_responce;
  // print_r($record->value('options')[]->value('val'));
  }
}?>
