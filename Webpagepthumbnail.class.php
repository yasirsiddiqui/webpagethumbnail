<?php
/**
 * Get web page thumbnails
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

require_once("config.php");

Class Webpagethumbnail {
    
    private $webpagelink;
    private $thumbpath;

    function getThumbnail($webpageurl) {
        
        $this->webpagelink = $webpageurl;
        
        if($this->filesExsistsInCache()==false) {    /// File is not there in cahce diretory so fetch image and save to cache
            
            // File is not there in cache so Make http call and download image
            $imagedataarray = $this->fetchThumbnail();
            
            if($imagedataarray[0]=="200") {   /// Success call so save image data to cache directory
                
                $this->saveImageToCahce($imagedataarray[1]);  // Save image data to cache directory
                return $this->thumbpath;
            }
            else return false; 
        }
        else {   //// File is there in cache so server cached file
            
            return $this->thumbpath;
        } 
    }
    
    function saveImageToCahce($imagedata) {
        
        $fp=fopen($this->thumbpath,'w');
        if($fp) {
        
        fwrite($fp,$imagedata);
	fclose($fp);
        }
        else return false;
    }
    
    /**
	 * Checks if file exsists in Cache. if so the return file path from cahce directory
								   
	 */
    
    private function filesExsistsInCache() {
        
        global $thumnail_config,$api_config;
        
        $md5checksum = md5($this->webpagelink);
        $filename = $md5checksum.".".$thumnail_config['encoding'];
        $filepath = $api_config['cache_dir']."/".$filename;
        $this->thumbpath = $filepath;
        
        if(file_exists($filepath)) {
           
           $filetime=filemtime($api_config['cache_dir']."/".$filename); 
           $cachetime = time()-$filetime-($api_config['cache_expirey_time']*60*60);
            
           if($cachetime>0) {   /// File cahce time has expired so fecth new thumb
                
             return false;
           }
           else if($cachetime<=0)
           
           return true;
        }
        else {
            
            return false;
        } 
    }
    
    /**
	 * Make http call and download image
								   
	 */
    
    private function fetchThumbnail() {
        
        global $thumnail_config;
        $url = $this->generateApiUrl();

        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,$thumnail_config['delay']+5); 
        curl_setopt($ch, CURLOPT_HEADER,1);
        
        $rawdata=curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        
        $imagedata = explode("\r\n\r\n",$rawdata);
        $imagebinarydata = $imagedata[2];
        return array($http_status,$imagebinarydata);
    }
    
    /**
	 * Generates web service URL
								   
	 */
    
    private function generateApiUrl () {
        
        global $api_config;
        
        if($api_config['api_key']=="YOUR_API_KEY"||$api_config['api_key']=="")  {
            
           throw new Exception("Please provide a valid api key");
        }
        
        global $api_config,$thumnail_config;
        $apiurl = $api_config['api_url']."?api_key=".$api_config['api_key']."&width=".$thumnail_config['imagewidth'].
        "&quality=".$thumnail_config['quality']."&output=pic&encoding=".$thumnail_config['encoding']."&watermark=".$thumnail_config['watermark'].
        "&mode=screen&delay=".$thumnail_config['delay']."&bwidth=".$thumnail_config['bwidth']."&bheight=".$thumnail_config['bheight'].
        "&url=".$this->webpagelink;
        
        return $apiurl; 
    }
    
}


?>