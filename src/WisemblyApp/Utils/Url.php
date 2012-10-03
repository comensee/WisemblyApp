<?php

namespace WisemblyApp\Utils;

/***
 * @author Alain Bangoula
 * class Allowing Basic cURL actions like POST, PUT, or GET
 * FeedBack appreciated :-)
 */
class Url {
    
    protected $link_url = null;
    protected $flux = null;
    protected $pattern = "#audios1.php\?([0-9a-zA-Z\-_]*=[0-9a-zA-Z]*&amp;)*#";


    public function __construct($link_url, $pattern = ''){
        $this->link_url = $link_url;
        $this->pattern = $pattern;
    }

    public function prepare_flux(){
        $flux =''; 
        return $flux;
    }

    public function grep_link(){
        $url_content = $this->get_url(); 
        $idx = 0;
        preg_match_all($this->pattern, $url_content, $links, PREG_SET_ORDER);
        foreach($links as $pattern):
            if(array_key_exists($idx, $pattern)):
                if(strlen($pattern[$idx][0]) > 13):
                    array_push($links, $pattern);
                endif;
            endif;
            $idx++;
        endforeach;
        return $links;
    }

    public function get($follow_location=false){
        $ch = curl_init();

        // configuration de l'URL et d'autres options
        curl_setopt($ch, CURLOPT_URL, $this->link_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 if($follow_location==true){
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER,array (
            "MIME-Version: 1.0",
            "Content-type: application/json;"
        ));
        // récupération de l'URL et affichage sur le naviguateur
        $response = curl_exec($ch);

        // fermeture de la session curl
        curl_close($ch);
        return $response;
    }

    private function put($datas){
        $ch = curl_init();
        
        // configuration de l'URL et d'autres options
        curl_setopt($ch, CURLOPT_URL, $this->link_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         
        curl_setopt($ch, CURLOPT_HTTPHEADER,array (
            "MIME-Version: 1.0",
            "Content-Type: application/json;"
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($datas));
        // récupération de l'URL et affichage sur le naviguateur
        $response = curl_exec($ch);

        // fermeture de la session curl
        curl_close($ch);
        return $response;
    }

    public function post($datas, $auth = null, $headers=array()){
        $ch = curl_init();
        
        if($auth):
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ; 
            curl_setopt($ch, CURLOPT_USERPWD, key($auth).":".$auth[key($auth)]); 
        endif;

        // configuration de l'URL et d'autres options
        curl_setopt($ch, CURLOPT_URL, $this->link_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($datas));
        // récupération de l'URL et affichage sur le naviguateur
        $response = curl_exec($ch);

        // fermeture de la session curl
        curl_close($ch);
        return $response;
    }



}





