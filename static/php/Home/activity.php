<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $CURRENT_ACTIVITY = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_activity"), true);

  $ACTIVITY = array();

  foreach ($CURRENT_ACTIVITY['response']['data']['sessions'] as $item) {
    $newItem = array();
    if ($item['media_type'] == "episode") {
      $newItem['series']['title'] = $item['grandparent_title'];
      $season = $item['parent_media_index'];
      $episode = $item['media_index'];
      if (strlen($season) == 1) {
        $newItem['series']['season'] = '0' . $season;
      } else {
        $newItem['series']['season'] = $season;
      }
      if (strlen($episode) == 1) {
        $newItem['series']['episode'] = '0' . $episode;
      } else {
        $newItem['series']['episode'] = $episode;
      }
      $newItem['series']['episode_title'] = $item['title'];
      $RATING_KEY = $item['grandparent_rating_key'];
      $newItem['images']['poster'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=poster";
      $newItem['images']['art'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=art";
    } else if ($item['media_type'] == 'movie') {
      $newItem['title'] = $item['title'];
      $RATING_KEY = $item['rating_key'];
      $newItem['images']['poster'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=poster";
      $newItem['images']['art'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=art";
    } else {
      continue;
    }
    $newItem['media_type'] = $item['media_type'];
    $newItem['playback']['progress_percent'] = $item['progress_percent'] . "%";
    $newItem['playback']['progress_ms'] = $item['view_offset'];
    $newItem['playback']['runtime_ms'] = $item['stream_duration'];
    $newItem['playback']['quality'] = $item['stream_video_resolution'];
    $newItem['playback']['state'] = $item['state'];
    $newItem['playback']['user'] = $item['friendly_name'];
    $newItem['id'] = $item['rating_key'];
    array_push($ACTIVITY, $newItem);
  }

  echo json_encode($ACTIVITY);

?>