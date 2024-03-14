<?php
namespace App\Helpers;

use Cache;

class Cloud
{
	public static function background($type,$id)
  {
    $type = strtolower($type);
      if($type == 'dokumen')
      {
        $bg = asset('assets/icon-cloud/001-doc-icon.png');
      }
      elseif($type == 'audio')
      {
        $bg = asset('assets/icon-cloud/001-audio-icon.png');
      }
      elseif($type == 'foto')
      {
        $bg = asset('assets/icon-cloud/001-img-icon.png');
      }
      elseif($type == 'video')
      {
        $bg = asset('assets/icon-cloud/001-video-icon.png');
      }
      else
      {
        $bg = asset('assets/icon-cloud/001-other-icon.png');
      }

      return $bg;
  }

  public static function formatBytes($bytes, $precision = 2) {
    $base = log($bytes, 1024);
  $suffixes = array('', 'K', 'M', 'G', 'T');

  return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
  }
}
