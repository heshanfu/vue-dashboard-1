<?php

  /*
    User changable configs
  */

  $API_KEY_PLEX = "";                         // api key for plex
  $API_KEY_SONARR = "";                       // api key for sonarr
  $API_KEY_RADARR = "";                       // api key for radarr
  $API_KEY_TAUTULLI = "";                     // api key for tautulli
  $API_KEY_TMDB = "";                         // api key to TMDB

  $CONNECTION  = "http";                      // http or https

  $GLOBAL_HOST = "127.0.0.1";                 // ip/url for reuse
  $PLEX_HOST = $GLOBAL_HOST;                  // ip/url for plex
  $SONARR_HOST = $GLOBAL_HOST;                // ip/url for sonarr
  $RADARR_HOST = $GLOBAL_HOST;                // ip/url for radarr
  $TAUTULLI_HOST = $GLOBAL_HOST;              // ip/url for tautulli
  $QBITTORRENT_HOST = $GLOBAL_HOST;           // ip/url for qbittorrent

  $PLEX_PORT = "32400";                       // port used by plex
  $SONARR_PORT = "8989";                      // port used by sonarr
  $RADARR_PORT = "7878";                      // port used by radarr
  $TAUTULLI_PORT = "9191";                    // port used by tautulli
  $QBITTORRENT_PORT = "8112";                 // port used by qbittorrent

  $SONARR_BASE = "";                          // base url if sonarr is behind a reverse proxy
  $RADARR_BASE = "";                          // base url if raadarr is behind a reverse proxy
  $TAUTULLI_BASE = "";                        // base url if tautulli is behind a reverse proxy


  /*
    Config items below this line should not be modified
  */

  $PLEX = "${CONNECTION}://${PLEX_HOST}:${PLEX_PORT}/statistics";
  $SONARR = "${CONNECTION}://${SONARR_HOST}:${SONARR_PORT}${SONARR_BASE}/api";
  $RADARR = "${CONNECTION}://${RADARR_HOST}:${RADARR_PORT}${RADARR_BASE}/api";
  $TAUTULLI = "${CONNECTION}://${TAUTULLI_HOST}:${TAUTULLI_PORT}${TAUTULLI_BASE}/api/v2";
  $QBITTORRENT = "${CONNECTION}://${QBITTORRENT_HOST}:${QBITTORRENT_PORT}/api/v2";

  $IMAGE_PROXY = "/static/php/Shared/image.php";

?>