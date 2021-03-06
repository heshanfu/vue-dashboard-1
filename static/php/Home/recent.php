<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $COUNT = 9;

  $RECENT_ADDED_SHOWS = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_recently_added&count=${COUNT}&type=show"), true);
  $RECENT_ADDED_MOVIES = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_recently_added&count=${COUNT}&type=movie"), true);

  $RECENT_ITEMS = array();

  foreach ($RECENT_ADDED_SHOWS['response']['data']['recently_added'] as $item) {
    $newItem = array();
    if ($item['media_type'] == "episode") {
      $newItem['title'] = $item['grandparent_title'];
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
      $newItem['image'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=thumb";
    } else if ($item['media_type'] == 'series') {
      // THIS IS CURRENTLY NEVER USED!
      $newItem['title'] = $item['parent_title'];
      $newItem['series']['season'] = $item['media_index'];
      $RATING_KEY = $item['rating_key'];
      $newItem['image'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=thumb";
    } else {
      continue;
    }
    $newItem['media_type'] = $item['media_type'];
    $newItem['added_at'] = $item['added_at'];
    array_push($RECENT_ITEMS, $newItem);
  }
  foreach ($RECENT_ADDED_MOVIES['response']['data']['recently_added'] as $item) {
    $newItem = array();
    if ($item['media_type'] == "movie") {
      $newItem['title'] = $item['full_title'];
    } else {
      continue;
    }
    $newItem['media_type'] = $item['media_type'];
    $RATING_KEY = $item['rating_key'];
    $newItem['image'] = "${IMAGE_PROXY}?rating_key=${RATING_KEY}&type=thumb";
    $newItem['added_at'] = $item['added_at'];
    array_push($RECENT_ITEMS, $newItem);
  }

  usort($RECENT_ITEMS, function ($a, $b) {
    if ($a['added_at'] == $b['added_at']) return 0;
    return ($a['added_at'] > $b['added_at']) ? -1 : 1;
  });

  echo json_encode(array_slice($RECENT_ITEMS, 0, $COUNT));

?>