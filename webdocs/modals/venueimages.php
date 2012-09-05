 <?php
  include_once facile::$path_classes . "/venue/venue.php";

  class venueImages{
    function process(){
      $tplData['records'] = array();
      $tplData['title'] = 'Venue Images';

      $tplData['Id'] = intval($_REQUEST['Id']);
      $tplData['records'] = Venue::get_venue_details($tplData['Id']);
      if($tplData['Id']>0){
        //thumnail image
        $tplData['thumbImg'] = getArtworkURL('venue', $tplData['Id'].'/thumbnail.jpg', '');

        $galleryImgFile = array();
        $gallery = findfile(facile::$web_venueimage_path.$tplData['Id'], '/^gal_(.*)$/');
        if(!empty($gallery)){
          foreach($gallery as $galleryImg){
            $fileName = basename($galleryImg);
            $galleryImgFile[] = getArtworkURL('venueGallery', $tplData['Id'].'/'.$fileName, '');//$fileName;
          }
        }
        $tplData['galleryImg'] = $galleryImgFile;
      }
      $tplData['tpl'] = 'venueImages_default.tpl';
      return $tplData;
    }
  }