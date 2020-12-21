<?php
if( !class_exists('Rdi_wp') ){
    class Rdi_wp {
        // propriedades
        private $client_id = '';
        private $client_secret = '';
        private $code = '';
        private $access_token = '';
        private $refresh_token = '';
        
        public function __construct(){
            $this->client_id = get_option(SSW_WPRDI_CLIENT_ID);
	        $this->client_secret = get_option(SSW_WPRDI_CLIENTE_SECRET);
	        $this->code = get_option(SSW_WPRDI_CODE);
	        $this->access_token = get_option(SSW_WPRDI_ACCESS_TOKEN);
	        $this->refresh_token = get_option(SSW_WPRDI_REFRESH_TOKEN);
        }
        
        // set properties
        public function setClientId($value){
            if (update_option(SSW_WPRDI_CLIENT_ID, $value)){
                $this->client_id = $value;
                return true;
            }
            return false;
        }
        public function setClientSecret($value){
            if (update_option(SSW_WPRDI_CLIENTE_SECRET, $value)){
                $this->client_secret = $value;
                return true;
            }
            return false;
        }
        public function setCode($value){
            if (update_option(SSW_WPRDI_CODE, $value)){
                $this->code = $value;
                return true;
            }
            return false;
        }
        private function setAccessToken($value){
            if (update_option(SSW_WPRDI_ACCESS_TOKEN, $value)){
                $this->access_token = $value;
                return true;
            }
            return false;
        }
        private function setRefreshToken($value){
            if (update_option(SSW_WPRDI_REFRESH_TOKEN, $value)){
                $this->refresh_token = $value;
                return true;
            }
            return false;
        }
        public function clearAll(){
            $this->setClientId('');
            $this->setClientSecret('');
            $this->setCode('');
            $this->setAccessToken('');
            $this->setRefreshToken('');
        }

        // get properties
        public function getClientId(){
            return $this->client_id;
        }
        public function getClientSecret(){
            return $this->client_secret;
        }
        public function getCode(){
            return $this->code;
        }

        // has properties
        public function hasClientId(){
            if($this->client_id) return true;
            return false;
        }
        public function hasClientSecret(){
            if($this->client_secret) return true;
            return false;
        }
        public function hasCode(){
            if($this->code) return true;
            return false;
        }
        public function hasAcessToken(){
            if($this->access_token) return true;
            return false;
        }
        public function hasRefreshToken(){
            if($this->refresh_token) return true;
            return false;
        }

        // funções de autenticação no RD
        public function getAccessAndRefreshToken(){
            $url = 'https://api.rd.services/auth/token';
            $payload = array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $this->code
            );
            $resp = $this->post($url, $payload);
            if(!isset($resp->access_token) || !isset($resp->refresh_token)){ return false; }
            if(isset($resp->access_token)){ $this->setAccessToken($resp->access_token); }
            if(isset($resp->refresh_token)){ $this->setRefreshToken($resp->refresh_token); }
            return true;
        }
        public function refreshToken(){
            //se não tem refresh token, então adquiri um
            if(!$this->hasRefreshToken()){
                return $this->getAccessAndRefreshToken();
            } else{
                // se tem refresh token, atualiza o token
                $url = 'https://api.rd.services/auth/token';
                $payload = array(
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'refresh_token' => $this->refresh_token
                );
                $resp = $this->post($url, $payload);
                if(!$resp->access_token || !$resp->refresh_token){ return false; }
                if($resp->access_token){ $this->setAccessToken($resp->access_token); }
                if($resp->refresh_token){ $this->setRefreshToken($resp->refresh_token); }
                return true;
            }
            return false;
        }

        /**
         * Recupera dados de um contato pelo email
         * https://developers.rdstation.com/pt-BR/reference/contacts#methodGetDetailsemail
         */
        public function getContactByEmail($email){
            $url = 'https://api.rd.services/platform/contacts/email:'.$email;
            //headers
            $headers = array(
                'Authorization' => 'Bearer '. $this->access_token
            );
            $resp = $this->get($url, $headers);
            if(isset($resp->email)){ return $resp; }
            else{ 
                // se não retornar resposta atualizo o token no servidor
                // atualizo o header e tento novamente
                if($this->refreshToken()){
                    //headers
                    $headers = array(
                        'Authorization' => 'Bearer '. $this->access_token
                    );
                    //envia
                    $resp = $this->get($url, $headers);
                    if(isset($resp->email)){ return $resp; }
                }
            }
            return false;
        }

        /**
         * funções de conversão RD
         * https://developers.rdstation.com/pt-BR/reference/events#conversionEventPostDetails
         */
        public function sendConversionEvent($id, $content){
            $url = 'https://api.rd.services/platform/events';
            //payload
            $pload = new stdClass();
            $pload->event_type = "CONVERSION";
            $pload->event_family = "CDP";
            $pload->payload = new stdClass();
            $pload->payload->conversion_identifier = $id;
            foreach ($content as $key => $value) {
                $pload->payload->{$key} = $value;
            }
            //headers
            $headers = array(
                'Authorization' => 'Bearer '. $this->access_token
            );
            $resp = $this->post($url, $pload, $headers);
            if(isset($resp->event_uuid)){ return $resp; }
            else{ 
                // se não retornar resposta atualizo o token no servidor
                // atualizo o header e tento novamente
                if($this->refreshToken()){
                    //headers
                    $headers = array(
                        'Authorization' => 'Bearer '. $this->access_token
                    );
                    //envia
                    $resp = $this->post($url, $pload, $headers);
                    if(isset($resp->event_uuid)){ return $resp; }
                }
            }
            return false;
            
        }

        /**
         * Editar contato do RD
         * https://developers.rdstation.com/pt-BR/reference/contacts#methodPatchDetails
         */
        public function editContact($id, $obj){
            $url = 'https://api.rd.services/platform/contacts/'. $id;
            //payload
            if (is_array($obj)) $obj = (object) $obj;
            //headers
            $headers = array(
                'Authorization' => 'Bearer '. $this->access_token
            );
            $resp = $this->patch($url, $obj, $headers);
            if(isset($resp->uuid)){ return $resp; }
            else{ 
                // se não retornar resposta atualizo o token no servidor
                // atualizo o header e tento novamente
                if($this->refreshToken()){
                    //headers
                    $headers = array(
                        'Authorization' => 'Bearer '. $this->access_token
                    );
                    //envia
                    $resp = $this->patch($url, $obj, $headers);
                    if(isset($resp->uuid)){ return $resp; }
                }
            }
            return false;
        }

        //funções auxiliares
        private function post($url, $payload, $headers = []){
            $ch = curl_init($url);
            // Attach encoded JSON string to the POST fields
            $payloadJsonEncoded = json_encode($payload);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJsonEncoded);
            // Set the content type to application/json
            $headersArray = array('Content-Type:application/json');
            foreach ($headers as $key => $value) {
                $headersArray[] = $key.':'.$value;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headersArray);
            
            // Return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Execute the POST request
            $result = curl_exec($ch);
            // Close cURL resource
            curl_close($ch);
            //return
            return json_decode($result);
        }
        /**
         * get
         */
        private function get($url, $headers = []){
            $ch = curl_init($url);
            // Set the content type to application/json
            $headersArray = array('Content-Type:application/json');
            foreach ($headers as $key => $value) {
                $headersArray[] = $key.':'.$value;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headersArray);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            // Close cURL resource
            curl_close($ch);
            //return
            return json_decode($result);
        }
        /**
         * patch
         */
        private function patch($url, $payload, $headers = []){
            $ch = curl_init($url);
            // Attach encoded JSON string to the POST fields
            $payloadJsonEncoded = json_encode($payload);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJsonEncoded);
            // Set the content type to application/json
            $headersArray = array('Content-Type:application/json');
            foreach ($headers as $key => $value) {
                $headersArray[] = $key.':'.$value;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headersArray);
            
            // Return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Execute the POST request
            $result = curl_exec($ch);
            // Close cURL resource
            curl_close($ch);
            //return
            return json_decode($result);
        }
    }
}