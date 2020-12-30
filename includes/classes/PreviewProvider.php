 
<?php

class PreviewProvider{
    
    private $con , $username;
    
    public function __construct($con, $username){
        $this->con = $con;
        $this->username = $username;
    }

    public function createPreveiwVideo($entity){
        if ($entity == null){
            $entity = $this->getRandomEntity();
        }
        
        $id = $entity->getId();
        $name = $entity->getName();
        $thumbnail = $entity->getThumbnail();
        $preview = $entity->getPreview();

        $videoId = VideoProvider::getEntityIdForUser($this->con, $id, $this->username );

        $video = new Video($this->con, $videoId);
        $inprogress = $video->isInProgress($this->username);
        $playButtonText = $inprogress ? "Reprendre" : "Play" ;

        $seasonEpisode = $video->getSeasonAndMovie();
        $subHeading =  $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>" ;

        return "<div class='previewContainer'>
                 
                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' type='video/mp4'> 
                    </video>    

                    <div class='previewOverlay'>
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            ". $subHeading ."
                            <div class='buttons'>
                                <button onclick='watchVideo($videoId)'><i class='fas fa-play' style='margin-right:5px'></i>$playButtonText</button>
                                <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>
                        
                        </div>
                    </div>
        
        </div>"; 

    }

    public function createTitleEntityPreview($entity){
        $id = $entity->getId();
        
    }

    public function createEntityPreviewSquare($entity){
        $id = $entity->getId();
        $thumbnail = $entity->getThumbnail();
        $name = $entity->getName();

        return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>";
    }

    public function createTvshowPreviewVideo(){
        $entitiesArray = EntityProvider::getTvshowsEntities($this->con, null, 1);

        if (sizeof($entitiesArray) == 0){
            ErrorMessage::show("Pas de Series Télé Disponible");
        }

        return $this->createPreveiwVideo($entitiesArray[0]);
    }

    public function createCategoyPreviewVideo($categoryId){
        $entitiesArray = EntityProvider::getEntities($this->con, $categoryId, 1);

        if (sizeof($entitiesArray) == 0){
            ErrorMessage::show("Pas de Series Télé Disponible");
        }

        return $this->createPreveiwVideo($entitiesArray[0]);
    }

    public function createMoviesPreviewVideo(){
        $entitiesArray = EntityProvider::getMoviesEntities($this->con, null, 1);

        if (sizeof($entitiesArray) == 0){
            ErrorMessage::show("Pas de Films Disponible");
        }

        return $this->createPreveiwVideo($entitiesArray[0]);
    }


    private function getRandomEntity(){
        $entity = EntityProvider::getEntities($this->con, null, 1);
        $entityTvshow = EntityProvider::getTvshowsEntities($this->con, null, 1);
        return $entity[0];

    }

    


 }

?>