<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $START = "";
  $END =  "";

  if (isset($_GET['start'])) {
    $START = "&start=" . $_GET['start'];
  }
  if (isset($_GET['end'])) {
    $END = "&end=" . $_GET['end'];
  }

  $MOVIES_QUEUE = json_decode(file_get_contents("${RADARR}/queue?apikey=${API_KEY_RADARR}"), true);
  $MOVIES_CALENDAR = json_decode(file_get_contents("${RADARR}/calendar?apikey=${API_KEY_RADARR}&unmonitored=false" . $START . $END), true);
  $MOVIES_DOWNLOADING = array();
  foreach ($MOVIES_QUEUE as $movie) {
    array_push($MOVIES_DOWNLOADING, $movie['movie']['tmdbId']);
  }
  foreach ($MOVIES_CALENDAR as &$movie) {
    if (in_array($movie['tmdbId'], $MOVIES_DOWNLOADING)) {
      $movie['downloading'] = true;
    } else {
      $movie['downloading'] = false;
    }
    $TMDB_ID = $movie['tmdbId'];
    $movie['images'][0]['url'] = "${IMAGE_PROXY}?tmdb_id=${TMDB_ID}";
  }

  echo json_encode($MOVIES_CALENDAR);

?>